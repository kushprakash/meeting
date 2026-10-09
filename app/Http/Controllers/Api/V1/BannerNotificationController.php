<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\Meeting;
use App\Models\NewsBanner;
use App\Models\Passbook;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BannerNotificationController extends Controller
{
    /**
     * Get news & meeting banners for compact sliding banner strip
     */
    public function getBanners(Request $request): JsonResponse
    {
        // 1. Fetch active custom news/image banners uploaded by admin
        $newsBanners = NewsBanner::where('is_active', true)->latest()->get();

        $slides = [];
        $newsMeetingUuids = [];
        $user = $request->user();

        // Add admin uploaded news & image banners
        foreach ($newsBanners as $b) {
            $type = 'news';
            $price = 0.0;
            $hostName = null;
            $hostId = null;
            $status = null;
            $isHostJoined = false;
            $alreadyPaid = false;
            $startsAt = null;

            if ($b->meeting_uuid) {
                $newsMeetingUuids[] = $b->meeting_uuid;
                $m = Meeting::where('uuid', $b->meeting_uuid)
                    ->with(['host:id,name,email', 'participants'])
                    ->first();

                if ($m) {
                    $type = 'meeting';
                    $isHostJoined = $m->participants
                        ->where('role', 'host')
                        ->where('status', 'joined')
                        ->isNotEmpty();

                    $isMeetingStarted = $m->status === 'active' || $m->status === 'started' || $isHostJoined;

                    if ($user) {
                        $hasPaidPassbook = Passbook::where('user_id', $user->id)
                            ->where('type', 'DR')
                            ->where('details', 'LIKE', '%Meeting Entry Fee:%'.$m->title.'%')
                            ->exists();

                        $alreadyPaid = $hasPaidPassbook || $m->participants
                            ->where('user_id', $user->id)
                            ->whereIn('status', ['joined', 'approved', 'left'])
                            ->isNotEmpty();
                    }

                    $price = (float) $m->price;
                    $hostName = $m->host?->name ?? 'Host';
                    $hostId = $m->host_id;
                    $status = $isMeetingStarted ? 'active' : $m->status;
                    $startsAt = $m->starts_at ? $m->starts_at->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s') : null;
                }
            }

            $slides[] = [
                'type' => $type,
                'title' => $b->title,
                'description' => $b->description ?? '',
                'image_url' => $b->image_url,
                'meeting_uuid' => $b->meeting_uuid,
                'price' => $price,
                'host_name' => $hostName,
                'host_id' => $hostId,
                'status' => $status,
                'is_host_joined' => $isHostJoined,
                'already_paid' => $alreadyPaid,
                'starts_at' => $startsAt,
            ];
        }

        // 2. Fetch active/started/scheduled meetings to slide as meeting banners (excluding ones already added via admin banners)
        $activeMeetings = Meeting::whereIn('status', ['active', 'started', 'scheduled'])
            ->whereNotIn('uuid', $newsMeetingUuids)
            ->with(['host:id,name,email', 'participants'])
            ->latest()
            ->take(10)
            ->get();

        // Add meeting banners
        foreach ($activeMeetings as $m) {
            $isHostJoined = $m->participants
                ->where('role', 'host')
                ->where('status', 'joined')
                ->isNotEmpty();

            $isMeetingStarted = $m->status === 'active' || $m->status === 'started' || $isHostJoined;

            $alreadyPaid = false;
            if ($user) {
                $hasPaidPassbook = Passbook::where('user_id', $user->id)
                    ->where('type', 'DR')
                    ->where('details', 'LIKE', '%Meeting Entry Fee:%'.$m->title.'%')
                    ->exists();

                $alreadyPaid = $hasPaidPassbook || $m->participants
                    ->where('user_id', $user->id)
                    ->whereIn('status', ['joined', 'approved', 'left'])
                    ->isNotEmpty();
            }

            $slides[] = [
                'type' => 'meeting',
                'title' => $m->title,
                'description' => $m->description ?? 'Audio Meeting by '.($m->host?->name ?? 'Host'),
                'image_url' => null,
                'meeting_uuid' => $m->uuid,
                'price' => (float) $m->price,
                'host_name' => $m->host?->name ?? 'Host',
                'host_id' => $m->host_id,
                'status' => $isMeetingStarted ? 'active' : $m->status,
                'is_host_joined' => $isHostJoined,
                'already_paid' => $alreadyPaid,
                'starts_at' => $m->starts_at ? $m->starts_at->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s') : null,
            ];
        }

        // Fallback default slide if empty
        if (empty($slides)) {
            $slides[] = [
                'type' => 'news',
                'title' => 'Welcome to Best Recharge',
                'description' => 'Best Recharge mobile APP to Mobile Recharge, DTH Recharge and Wallet',
                'image_url' => null,
                'meeting_uuid' => null,
                'price' => 0.0,
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'banners' => $slides,
            ],
        ]);
    }

    /**
     * Get notifications list
     */
    public function getNotifications(Request $request): JsonResponse
    {
        $user = $request->user();
        $now = Carbon::now('Asia/Kolkata');

        $rawNotifications = AppNotification::where(function ($q) use ($user) {
            $q->whereNull('user_id')
                ->orWhere('user_id', $user->id);
        })
            ->latest()
            ->take(40)
            ->get();

        $notifications = [];
        foreach ($rawNotifications as $n) {
            if (! empty($n->meeting_uuid)) {
                $meeting = Meeting::where('uuid', $n->meeting_uuid)->first();
                // Exclude notification if meeting is missing, ended, or expired
                if (! $meeting || $meeting->status === 'ended') {
                    continue;
                }
                if ($meeting->ends_at) {
                    $endsAt = Carbon::parse($meeting->ends_at)->setTimezone('Asia/Kolkata');
                    if ($now->greaterThan($endsAt)) {
                        continue;
                    }
                }
                if ($meeting->starts_at) {
                    $startsAt = Carbon::parse($meeting->starts_at)->setTimezone('Asia/Kolkata');
                    if ($now->diffInHours($startsAt, false) < -12) {
                        continue;
                    }
                }
            }
            $notifications[] = $n;
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'unread_count' => count($notifications),
                'notifications' => array_values($notifications),
            ],
        ]);
    }

    /**
     * Mark notification read
     */
    public function markRead(Request $request, int $id): JsonResponse
    {
        $user = $request->user();
        $notification = AppNotification::where('id', $id)
            ->where(function ($q) use ($user) {
                $q->whereNull('user_id')->orWhere('user_id', $user->id);
            })->first();

        if ($notification) {
            $notification->update(['is_read' => true]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Notification marked as read',
        ]);
    }
}
