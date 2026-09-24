<?php

namespace App\Events;

use App\Models\MeetingParticipant;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JoinApproved implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public MeetingParticipant $participant;
    public ?string $token;
    public ?string $livekitHost;

    public function __construct(MeetingParticipant $participant, ?string $token = null, ?string $livekitHost = null)
    {
        $this->participant = $participant;
        $this->token = $token;
        $this->livekitHost = $livekitHost;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->participant->user_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'join.approved';
    }
}
