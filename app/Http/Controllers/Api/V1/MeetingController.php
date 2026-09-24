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
            'max_participants' => 'nullable|integer|min:1',
            'allow_audio' => 'boolean',
            'allow_video' => 'boolean',
            'allow_screen_share' => 'boolean',
            'allow_chat' => 'boolean',
            'invited_emails' => 'nullable|array',
            'invited_emails.*' => 'email',
        ]);

        $host = $request->user();

        $meeting = Meeting::create([
            'uuid' => Str::uuid()->toString(),
            'title' => $validated['title'],
            'host_id' => $host->id,
            'visibility' => $validated['visibility'],
            'approval_required' => $validated['approval_required'] ?? ($validated['visibility'] === 'public'),
            'starts_at' => $validated['starts_at'] ?? null,
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

        $hosted = Meeting::where('host_id', $user->id)->with('host:id,name,email')->latest()->get();

        $invitedMeetingIds = MeetingParticipant::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('email', $user->email);
        })->pluck('meeting_id');

        $participating = Meeting::whereIn('id', $invitedMeetingIds)
            ->where('host_id', '!=', $user->id)
            ->with('host:id,name,email')
            ->latest()
            ->get();

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

        return response()->json([
            'status' => 'success',
            'data' => [
                'meeting' => $meeting,
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
