<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\Meeting;
use App\Models\NewsBanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BannerNotificationController extends Controller
{
    /**
     * Get news & meeting banners for compact sliding banner strip
     */
    public function getBanners(Request $request): JsonResponse
    {
        // 1. Fetch active custom news banners
        $newsBanners = NewsBanner::where('is_active', true)->latest()->get();

        // 2. Fetch active meetings to slide as meeting banners
        $activeMeetings = Meeting::where('status', 'active')
            ->with('host:id,name,email')
            ->latest()
            ->take(10)
            ->get();

        $slides = [];

        // Add news banners
        foreach ($newsBanners as $b) {
            $slides[] = [
                'type' => 'news',
                'title' => $b->title,
                'description' => $b->description ?? '',
                'image_url' => $b->image_url,
                'meeting_uuid' => $b->meeting_uuid,
                'price' => 0.0,
            ];
        }

        // Add meeting banners
        foreach ($activeMeetings as $m) {
            $slides[] = [
                'type' => 'meeting',
                'title' => $m->title,
                'description' => $m->description ?? 'Live Audio Meeting by ' . ($m->host?->name ?? 'Host'),
                'image_url' => null,
                'meeting_uuid' => $m->uuid,
                'price' => (float)$m->price,
                'host_name' => $m->host?->name ?? 'Host',
                'host_id' => $m->host_id,
                'starts_at' => $m->starts_at ? $m->starts_at->toIso8601String() : null,
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
            ]
        ]);
    }

    /**
     * Get notifications list
     */
    public function getNotifications(Request $request): JsonResponse
    {
        $user = $request->user();

        $notifications = AppNotification::where(function ($q) use ($user) {
            $q->whereNull('user_id')
              ->orWhere('user_id', $user->id);
        })
        ->latest()
        ->take(30)
        ->get();

        $unreadCount = AppNotification::where(function ($q) use ($user) {
            $q->whereNull('user_id')
              ->orWhere('user_id', $user->id);
        })
        ->where('is_read', false)
        ->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'unread_count' => $unreadCount,
                'notifications' => $notifications,
            ]
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
            'message' => 'Notification marked as read'
        ]);
    }
}
