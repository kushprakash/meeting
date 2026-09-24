<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingParticipant;
use App\Services\LiveKitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HostApprovalController extends Controller
{
    protected LiveKitService $liveKitService;

    public function __construct(LiveKitService $liveKitService)
    {
        $this->liveKitService = $liveKitService;
    }

    /**
     * Get pending join requests for host
     */
    public function pendingRequests(Request $request, string $uuid): JsonResponse
    {
        $meeting = Meeting::where('uuid', $uuid)->firstOrFail();
        
        if ($meeting->host_id !== $request->user()->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Host only.'], 403);
        }

        $pending = MeetingParticipant::where('meeting_id', $meeting->id)
            ->where('status', 'pending')
            ->with('user:id,name,email')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'pending_requests' => $pending,
            ]
        ]);
    }

    /**
     * Approve a participant's join request
     */
    public function approve(Request $request, string $uuid, int $participantId): JsonResponse
    {
        $meeting = Meeting::where('uuid', $uuid)->firstOrFail();
        $host = $request->user();

        if ($meeting->host_id !== $host->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Host only.'], 403);
        }

        $participant = MeetingParticipant::where('meeting_id', $meeting->id)
            ->where('id', $participantId)
            ->firstOrFail();

        $participant->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $host->id,
        ]);

        // Generate LiveKit token if user model exists
        $token = null;
        if ($participant->user) {
            $token = $this->liveKitService->generateToken($meeting, $participant->user, $participant->role);
            \App\Events\JoinApproved::dispatch($participant, $token, $this->liveKitService->getHostUrl());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Participant approved successfully',
            'data' => [
                'participant' => $participant->fresh(['user:id,name,email']),
                'token' => $token,
                'livekit_host' => $this->liveKitService->getHostUrl(),
            ]
        ]);
    }

    /**
     * Reject a participant's join request
     */
    public function reject(Request $request, string $uuid, int $participantId): JsonResponse
    {
        $meeting = Meeting::where('uuid', $uuid)->firstOrFail();

        if ($meeting->host_id !== $request->user()->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Host only.'], 403);
        }

        $participant = MeetingParticipant::where('meeting_id', $meeting->id)
            ->where('id', $participantId)
            ->firstOrFail();

        $participant->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Participant request rejected',
            'data' => [
                'participant' => $participant,
            ]
        ]);
    }

    /**
     * Remove an active participant from meeting
     */
    public function remove(Request $request, string $uuid, int $participantId): JsonResponse
    {
        $meeting = Meeting::where('uuid', $uuid)->firstOrFail();

        if ($meeting->host_id !== $request->user()->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Host only.'], 403);
        }

        $participant = MeetingParticipant::where('meeting_id', $meeting->id)
            ->where('id', $participantId)
            ->firstOrFail();

        $participant->update([
            'status' => 'removed',
            'left_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Participant removed from meeting',
            'data' => [
                'participant' => $participant,
            ]
        ]);
    }

    /**
     * Block a participant from re-joining meeting
     */
    public function block(Request $request, string $uuid, int $participantId): JsonResponse
    {
        $meeting = Meeting::where('uuid', $uuid)->firstOrFail();

        if ($meeting->host_id !== $request->user()->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Host only.'], 403);
        }

        $participant = MeetingParticipant::where('meeting_id', $meeting->id)
            ->where('id', $participantId)
            ->firstOrFail();

        $participant->update([
            'status' => 'blocked',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Participant blocked successfully',
            'data' => [
                'participant' => $participant,
            ]
        ]);
    }
}
