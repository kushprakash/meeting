<?php

namespace App\Services;

use App\Models\Meeting;
use App\Models\User;
use Firebase\JWT\JWT;

class LiveKitService
{
    protected string $apiKey;
    protected string $apiSecret;
    protected string $hostUrl;

    public function __construct()
    {
        $this->apiKey = config('services.livekit.api_key', env('LIVEKIT_API_KEY', 'devkey'));
        $this->apiSecret = config('services.livekit.api_secret', env('LIVEKIT_API_SECRET', 'devsecretkeyforlivekittoken123456'));
        $this->hostUrl = config('services.livekit.host', env('LIVEKIT_HOST', 'wss://vidbez.com/livekit/'));
    }

    /**
     * Generate LiveKit JWT Token for a validated participant.
     */
    public function generateToken(Meeting $meeting, User $user, string $role = 'participant'): string
    {
        $now = time();
        $ttl = 60 * 60 * 6; // 6 hours token validity

        $isHost = ($meeting->host_id === $user->id) || ($role === 'host');

        // Determine publishing permissions based on meeting configuration & role
        $canPublish = $isHost || ($meeting->allow_audio || $meeting->allow_video);
        $canPublishData = $isHost || $meeting->allow_chat;

        $sources = [];
        if ($isHost || $meeting->allow_video) {
            $sources[] = 'camera';
        }
        if ($isHost || $meeting->allow_audio) {
            $sources[] = 'microphone';
        }
        if ($isHost || $meeting->allow_screen_share) {
            $sources[] = 'screen_share';
            $sources[] = 'screen_share_audio';
        }

        $videoGrant = [
            'room' => $meeting->uuid,
            'roomJoin' => true,
            'canPublish' => $canPublish,
            'canSubscribe' => true,
            'canPublishData' => $canPublishData,
        ];

        if (!empty($sources)) {
            $videoGrant['canPublishSources'] = $sources;
        }

        if ($isHost) {
            $videoGrant['roomAdmin'] = true;
            $videoGrant['roomCreate'] = true;
        }

        // Set participant identity to user email for clean WebRTC track mapping across clients
        $identity = strtolower($user->email);

        $payload = [
            'iss' => $this->apiKey,
            'sub' => $identity,
            'name' => $user->name,
            'nbf' => $now,
            'exp' => $now + $ttl,
            'video' => $videoGrant,
            'metadata' => json_encode([
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $role,
            ]),
        ];

        return JWT::encode($payload, $this->apiSecret, 'HS256');
    }

    public function getHostUrl(): string
    {
        return $this->hostUrl;
    }
}
