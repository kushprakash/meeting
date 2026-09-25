<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingParticipant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MeetingController extends Controller
{
    /**
     * Create a new meeting (Private or Public)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'visibility' => 'required|in:private,public',
            'approval_required' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'duration_minutes' => 'nullable|integer|min:1|max:1440',
            'max_participants' => 'nullable|integer|min:1',
            'allow_audio' => 'boolean',
            'allow_video' => 'boolean',
            'allow_screen_share' => 'boolean',
            'allow_chat' => 'boolean',
            'invited_emails' => 'nullable|array',
            'invited_emails.*' => 'email',
        ]);

        $host = $request->user();

        $startsAt = !empty($validated['starts_at']) ? \Carbon\Carbon::parse($validated['starts_at']) : now();
        $durationMinutes = !empty($validated['duration_minutes']) ? (int)$validated['duration_minutes'] : 60; // Standard 60 mins default if not scheduled
        $endsAt = !empty($validated['ends_at']) 
            ? \Carbon\Carbon::parse($validated['ends_at']) 
            : (clone $startsAt)->addMinutes($durationMinutes);

        $meeting = Meeting::create([
            'uuid' => Str::uuid()->toString(),
            'title' => $validated['title'],
            'host_id' => $host->id,
            'visibility' => $validated['visibility'],
            'approval_required' => $validated['approval_required'] ?? ($validated['visibility'] === 'public'),
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'max_participants' => $validated['max_participants'] ?? null,
            'allow_audio' => $validated['allow_audio'] ?? true,
            'allow_video' => $validated['allow_video'] ?? true,
            'allow_screen_share' => $validated['allow_screen_share'] ?? true,
            'allow_chat' => $validated['allow_chat'] ?? true,
            'status' => 'active',
        ]);

        // Add Host as participant with status 'approved' and role 'host'
        MeetingParticipant::create([
            'meeting_id' => $meeting->id,
            'user_id' => $host->id,
            'email' => $host->email,
            'role' => 'host',
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $host->id,
        ]);

        // Add invited emails for both private and public meetings
        if (!empty($validated['invited_emails'])) {
            foreach ($validated['invited_emails'] as $email) {
                $cleanEmail = strtolower(trim($email));
                if ($cleanEmail === $host->email) {
                    continue; // skip host email
                }

                $existingUser = User::where('email', $cleanEmail)->first();

                MeetingParticipant::updateOrCreate(
                    [
                        'meeting_id' => $meeting->id,
                        'email' => $cleanEmail,
                    ],
                    [
                        'user_id' => $existingUser?->id,
                        'role' => 'participant',
                        'status' => 'invited',
                        'invited_at' => now(),
                    ]
                );
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Meeting created successfully',
            'data' => [
                'meeting' => $meeting->load(['host:id,name,email', 'participants']),
            ]
        ], 201);
    }

    /**
     * List user's meetings (hosted + invited)
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $now = now();

        // Mark meetings created > 24 hours ago as ended
        Meeting::where('status', 'active')
            ->where('created_at', '<', $now->copy()->subHours(24))
            ->update(['status' => 'ended']);

        $hosted = Meeting::where('host_id', $user->id)
            ->with(['host:id,name,email', 'participants.user:id,name,email'])
            ->latest()
            ->get()
            ->map(function ($m) use ($now) {
                $m->is_expired = ($m->status === 'ended') 
                    || ($m->created_at && $now->diffInHours($m->created_at) >= 24);
                return $m;
            });

        $invitedMeetingIds = MeetingParticipant::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('email', $user->email);
        })->pluck('meeting_id');

        $participating = Meeting::whereIn('id', $invitedMeetingIds)
            ->where('host_id', '!=', $user->id)
            ->with(['host:id,name,email', 'participants.user:id,name,email'])
            ->latest()
            ->get()
            ->map(function ($m) use ($now) {
                $m->is_expired = ($m->status === 'ended') 
                    || ($m->created_at && $now->diffInHours($m->created_at) >= 24);
                return $m;
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'hosted' => $hosted,
                'participating' => $participating,
            ]
        ]);
    }

    /**
     * Get details of a specific meeting
     */
    public function show(Request $request, string $uuid): JsonResponse
    {
        $meeting = Meeting::where('uuid', $uuid)->with(['host:id,name,email', 'participants.user:id,name,email'])->firstOrFail();

        $now = now();
        $isExpired = ($meeting->status === 'ended') || ($meeting->created_at && $now->diffInHours($meeting->created_at) >= 24);
        $isStarted = $meeting->starts_at ? $now->gte($meeting->starts_at) : true;

        if ($isExpired && $meeting->status === 'active') {
            $meeting->update(['status' => 'ended']);
            $meeting->status = 'ended';
        }

        // Filter active participants only (joined or approved with no left_at timestamp)
        $activeParticipants = MeetingParticipant::where('meeting_id', $meeting->id)
            ->whereIn('status', ['joined', 'approved'])
            ->whereNull('left_at')
            ->with('user:id,name,email')
            ->get();
        $meeting->setRelation('participants', $activeParticipants);

        return response()->json([
            'status' => 'success',
            'data' => [
                'meeting' => $meeting,
                'active_participants' => $activeParticipants,
                'is_expired' => $isExpired || $meeting->status === 'ended',
                'is_started' => $isStarted,
                'remaining_seconds' => 3600,
                'starts_in_seconds' => 0,
            ]
        ]);
    }

    /**
     * Get real-time room activity & active participants only
     */
    public function roomActivity(Request $request, string $uuid): JsonResponse
    {
        $meeting = Meeting::where('uuid', $uuid)->with(['host:id,name,email'])->firstOrFail();
        $user = $request->user();

        $now = now();
        $isExpired = ($meeting->status === 'ended') || ($meeting->created_at && $now->diffInHours($meeting->created_at) >= 24);

        if ($isExpired && $meeting->status === 'active') {
            $meeting->update(['status' => 'ended']);
        }

        // Check current requesting user's participant status
        $myParticipant = null;
        if ($user) {
            $myParticipant = MeetingParticipant::where('meeting_id', $meeting->id)
                ->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->orWhere('email', strtolower($user->email));
                })->first();
        }

        $myStatus = $myParticipant ? $myParticipant->status : null;
        $isKickedOrRemoved = $myParticipant && in_array($myParticipant->status, ['removed', 'blocked', 'rejected']);

        // Active room participants (Joined or Approved with no left_at timestamp)
        $activeParticipants = MeetingParticipant::where('meeting_id', $meeting->id)
            ->whereIn('status', ['joined', 'approved'])
            ->whereNull('left_at')
            ->with('user:id,name,email')
            ->get();

        // Pending join requests for host - Always fetch if user is Host
        $pendingRequests = [];
        $isHost = $user && ($meeting->host_id === $user->id || strtolower($meeting->host?->email) === strtolower($user->email));

        if ($isHost) {
            $pendingRequests = MeetingParticipant::where('meeting_id', $meeting->id)
                ->where('status', 'pending')
                ->with('user:id,name,email')
                ->get();
        }

        $meeting->setRelation('participants', $activeParticipants);

        return response()->json([
            'status' => 'success',
            'data' => [
                'meeting' => $meeting,
                'active_participants' => $activeParticipants,
                'pending_requests' => $pendingRequests,
                'is_host' => $isHost,
                'is_expired' => $isExpired,
                'my_status' => $myStatus,
                'is_kicked_or_removed' => $isKickedOrRemoved,
            ]
        ]);
    }

    /**
     * Add or manage invited emails for Private meeting (Host only)
     */
    public function invite(Request $request, string $uuid): JsonResponse
    {
        $meeting = Meeting::where('uuid', $uuid)->firstOrFail();
        $user = $request->user();

        if ($meeting->host_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Only host can invite participants.'
            ], 403);
        }

        $validated = $request->validate([
            'emails' => 'required|array|min:1',
            'emails.*' => 'email',
        ]);

        $added = [];
        foreach ($validated['emails'] as $email) {
            $cleanEmail = strtolower(trim($email));
            $targetUser = User::where('email', $cleanEmail)->first();

            $participant = MeetingParticipant::updateOrCreate(
                [
                    'meeting_id' => $meeting->id,
                    'email' => $cleanEmail,
                ],
                [
                    'user_id' => $targetUser?->id,
                    'role' => 'participant',
                    'status' => 'invited',
                    'invited_at' => now(),
                ]
            );
            $added[] = $participant;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Invited participants updated successfully',
            'data' => [
                'participants' => $added,
            ]
        ]);
    }

    /**
     * Revoke an invitation (Host only)
     */
    public function revokeInvite(Request $request, string $uuid, int $participantId): JsonResponse
    {
        $meeting = Meeting::where('uuid', $uuid)->firstOrFail();
        $user = $request->user();

        if ($meeting->host_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized.'
            ], 403);
        }

        $participant = MeetingParticipant::where('meeting_id', $meeting->id)->where('id', $participantId)->firstOrFail();
        $participant->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Invitation revoked successfully'
        ]);
    }
}
