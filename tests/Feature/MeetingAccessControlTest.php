<?php

namespace Tests\Feature;

use App\Models\Meeting;
use App\Models\MeetingParticipant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeetingAccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_login_with_otp_verification()
    {
        // 1. Register with Email & Password
        $regResponse = $this->postJson('/api/v1/register', [
            'name' => 'Host User',
            'email' => 'host@example.com',
            'password' => 'password123',
        ]);

        $regResponse->assertStatus(201)
            ->assertJson(['status' => 'pending_otp']);

        $otpDemo = $regResponse->json('data.otp_demo');
        $this->assertNotEmpty($otpDemo);

        // 2. Verify OTP
        $verifyResponse = $this->postJson('/api/v1/auth/verify-otp', [
            'email' => 'host@example.com',
            'otp_code' => $otpDemo,
        ]);

        $verifyResponse->assertStatus(200)
            ->assertJsonStructure(['status', 'data' => ['token', 'user']]);

        // 3. Login with Email & Password
        $loginResponse = $this->postJson('/api/v1/login', [
            'email' => 'host@example.com',
            'password' => 'password123',
        ]);

        $loginResponse->assertStatus(200)
            ->assertJsonStructure(['status', 'data' => ['token', 'user']]);
    }

    public function test_private_meeting_allows_invited_user_and_rejects_uninvited_user()
    {
        $host = User::factory()->create(['email' => 'host@example.com']);
        $invitedUser = User::factory()->create(['email' => 'invited@example.com']);
        $uninvitedUser = User::factory()->create(['email' => 'stranger@example.com']);

        // Host creates private meeting with invited@example.com
        $meetingResponse = $this->actingAs($host, 'sanctum')->postJson('/api/v1/meetings', [
            'title' => 'Confidential Training',
            'visibility' => 'private',
            'invited_emails' => ['invited@example.com'],
        ]);

        $meetingResponse->assertStatus(201);
        $uuid = $meetingResponse->json('data.meeting.uuid');

        // Invited user tries to join -> Access Granted
        $invitedJoin = $this->actingAs($invitedUser, 'sanctum')->postJson("/api/v1/meetings/{$uuid}/join");
        $invitedJoin->assertStatus(200)
            ->assertJson(['status' => 'success', 'data' => ['access' => 'granted']]);

        // Uninvited user tries to join -> Access Denied
        $uninvitedJoin = $this->actingAs($uninvitedUser, 'sanctum')->postJson("/api/v1/meetings/{$uuid}/join");
        $uninvitedJoin->assertStatus(403)
            ->assertJson(['status' => 'error', 'code' => 'ACCESS_DENIED']);
    }

    public function test_public_meeting_approval_flow()
    {
        $host = User::factory()->create(['email' => 'host@example.com']);
        $participant = User::factory()->create(['email' => 'user@example.com']);

        // Host creates public meeting requiring approval
        $meetingResponse = $this->actingAs($host, 'sanctum')->postJson('/api/v1/meetings', [
            'title' => 'Public Webinar',
            'visibility' => 'public',
            'approval_required' => true,
        ]);

        $meetingResponse->assertStatus(201);
        $uuid = $meetingResponse->json('data.meeting.uuid');

        // Participant requests to join -> 202 Pending
        $joinRequest = $this->actingAs($participant, 'sanctum')->postJson("/api/v1/meetings/{$uuid}/join");
        $joinRequest->assertStatus(202)
            ->assertJson(['status' => 'pending', 'code' => 'WAITING_FOR_HOST_APPROVAL']);

        $participantId = $joinRequest->json('data.participant_id');

        // Host gets pending list
        $pendingList = $this->actingAs($host, 'sanctum')->getJson("/api/v1/meetings/{$uuid}/pending");
        $pendingList->assertStatus(200)->assertJsonCount(1, 'data.pending_requests');

        // Host approves participant
        $approve = $this->actingAs($host, 'sanctum')->postJson("/api/v1/meetings/{$uuid}/approve/{$participantId}");
        $approve->assertStatus(200)->assertJsonStructure(['data' => ['token']]);

        // Participant joins again -> Granted with LiveKit token
        $participantJoin = $this->actingAs($participant, 'sanctum')->postJson("/api/v1/meetings/{$uuid}/join");
        $participantJoin->assertStatus(200)
            ->assertJson(['status' => 'success', 'data' => ['access' => 'granted']]);
    }

    public function test_pre_invited_email_user_bypasses_waiting_room_and_joins_directly()
    {
        $host = User::factory()->create(['email' => 'host@example.com']);
        $preInvitedUser = User::factory()->create(['email' => 'vip_guest@company.com']);

        // Host creates public meeting with approval required BUT pre-invites vip_guest@company.com
        $meetingResponse = $this->actingAs($host, 'sanctum')->postJson('/api/v1/meetings', [
            'title' => 'VIP Corporate Sync',
            'visibility' => 'public',
            'approval_required' => true,
            'invited_emails' => ['vip_guest@company.com'],
        ]);

        $meetingResponse->assertStatus(201);
        $uuid = $meetingResponse->json('data.meeting.uuid');

        // Pre-invited user joins -> Direct Access (Status 200, status = success, LiveKit Token issued!)
        $joinResponse = $this->actingAs($preInvitedUser, 'sanctum')->postJson("/api/v1/meetings/{$uuid}/join");
        $joinResponse->assertStatus(200)
            ->assertJson(['status' => 'success', 'data' => ['access' => 'granted']]);
    }
}
