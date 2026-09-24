<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingParticipant;
use App\Services\LiveKitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeetingJoinController extends Controller
{
    protected LiveKitService $liveKitService;

    public function __construct(LiveKitService $liveKitService)
    {
        $this->liveKitService = $liveKitService;
    }

    /**
     * Join API enforcing 12 security validation checks (PRD 24.7)
     * POST /api/v1/meetings/{uuid}/join
     */
    public function join(Request $request, string $uuid): JsonResponse
    {
        // Check 4: User authenticated?
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'code' => 'UNAUTHENTICATED',
                'message' => 'User authentication is required to join meetings.'
            ], 401);
        }

        // Check 1: Meeting exists?
        $meeting = Meeting::where('uuid', $uuid)->first();
        if (!$meeting) {
            return response()->json([
                'status' => 'error',
                'code' => 'MEETING_NOT_FOUND',
                'message' => 'Meeting does not exist.'
            ], 404);
        }

        // Check 2: Meeting active?
        if ($meeting->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'code' => 'MEETING_INACTIVE',
                'message' => 'Meeting is not currently active.'
            ], 400);
        }

        // Check 3: Meeting time valid?
        $now = now();
        if ($meeting->starts_at && $now->lt($meeting->starts_at)) {
            return response()->json([
                'status' => 'error',
                'code' => 'MEETING_NOT_STARTED',
                'message' => 'Meeting has not started yet.',
                'starts_at' => $meeting->starts_at
            ], 400);
        }

        if ($meeting->ends_at && $now->gt($meeting->ends_at)) {
            return response()->json([
                'status' => 'error',
                'code' => 'MEETING_EXPIRED',
                'message' => 'Meeting has ended.'
            ], 400);
        }

        // Check 9: User blocked or removed?
        $participant = MeetingParticipant::where('meeting_id', $meeting->id)
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('email', strtolower($user->email));
            })->first();

        if ($participant && in_array($participant->status, ['blocked', 'removed'])) {
            return response()->json([
                'status' => 'error',
                'code' => 'ACCESS_DENIED',
                'message' => 'You have been blocked or removed from this meeting.'
            ], 403);
        }

        // Check 10 & Special Case: Is Host?
        $isHost = $meeting->isHost($user);
        if ($isHost) {
            // Host gets direct token
            $token = $this->liveKitService->generateToken($meeting, $user, 'host');
            return response()->json([
                'status' => 'success',
                'message' => 'Welcome Host! Access granted.',
                'data' => [
                    'access' => 'granted',
                    'role' => 'host',
                    'token' => $token,
                    'livekit_host' => $this->liveKitService->getHostUrl(),
                    'room' => $meeting->uuid,
                ]
            ]);
        }

        // Special Case: Pre-invited Email User Direct Join Bypass!
        if ($participant && $participant->status === 'invited') {
            $participant->update([
                'user_id' => $user->id,
                'status' => 'joined',
                'joined_at' => now(),
            ]);

            $token = $this->liveKitService->generateToken($meeting, $user, $participant->role);
            return response()->json([
                'status' => 'success',
                'message' => 'Pre-invited guest verified! Direct access granted.',
                'data' => [
                    'access' => 'granted',
                    'role' => $participant->role,
                    'token' => $token,
                    'livekit_host' => $this->liveKitService->getHostUrl(),
                    'room' => $meeting->uuid,
                ]
            ]);
        }

        // Check 5 & 6: Private Meeting & Email Invite check
        if ($meeting->isPrivate()) {
            if (!$participant || !in_array($participant->status, ['approved', 'joined'])) {
                return response()->json([
                    'status' => 'error',
                    'code' => 'ACCESS_DENIED',
                    'message' => 'Access Denied: You are not invited to this private meeting.'
                ], 403);
            }
        }

        // Check 7 & 8: Public Meeting & Approval Required Check
        if ($meeting->isPublic() && $meeting->approval_required) {
            // Check if user has already been approved or joined
            if (!$participant || !in_array($participant->status, ['approved', 'joined'])) {
                // If participant doesn't exist, create a pending join request
                if (!$participant) {
                    $participant = MeetingParticipant::create([
                        'meeting_id' => $meeting->id,
                        'user_id' => $user->id,
                        'email' => strtolower($user->email),
                        'role' => 'participant',
                        'status' => 'pending',
                    ]);
                }

                // Dispatch realtime event to host
                \App\Events\JoinRequested::dispatch($participant);

                // If request is rejected
                if ($participant->status === 'rejected') {
                    return response()->json([
                        'status' => 'error',
                        'code' => 'JOIN_REJECTED',
                        'message' => 'Host rejected your request to join this meeting.'
                    ], 403);
                }

                return response()->json([
                    'status' => 'pending',
                    'code' => 'WAITING_FOR_HOST_APPROVAL',
                    'message' => 'Join request sent. Waiting for host approval...',
                    'data' => [
                        'participant_id' => $participant->id,
                        'status' => 'pending',
                    ]
                ], 202); // 202 Accepted (Waiting)
            }
        }

        // Check 11: Meeting capacity available?
        if ($meeting->max_participants) {
            $activeCount = MeetingParticipant::where('meeting_id', $meeting->id)
                ->whereIn('status', ['joined', 'approved'])
                ->count();

            if ($activeCount >= $meeting->max_participants) {
                return response()->json([
                    'status' => 'error',
                    'code' => 'MEETING_FULL',
                    'message' => 'Meeting capacity has been reached.'
                ], 400);
            }
        }

        // Check 12: LiveKit Token Generation Valid
        // Update participant status to joined/approved if not already
        if (!$participant) {
            $participant = MeetingParticipant::create([
                'meeting_id' => $meeting->id,
                'user_id' => $user->id,
                'email' => strtolower($user->email),
                'role' => 'participant',
                'status' => 'approved',
                'approved_at' => now(),
            ]);
        } elseif ($participant->status !== 'joined') {
            $participant->update([
                'status' => 'joined',
                'joined_at' => now(),
            ]);
        }

        $token = $this->liveKitService->generateToken($meeting, $user, $participant->role);

        return response()->json([
            'status' => 'success',
            'message' => 'Access granted. LiveKit token generated successfully.',
            'data' => [
                'access' => 'granted',
                'role' => $participant->role,
                'token' => $token,
                'livekit_host' => $this->liveKitService->getHostUrl(),
                'room' => $meeting->uuid,
            ]
        ]);
    }
}
