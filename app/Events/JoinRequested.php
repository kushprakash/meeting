<?php

namespace App\Events;

use App\Models\MeetingParticipant;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JoinRequested implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public MeetingParticipant $participant;

    public function __construct(MeetingParticipant $participant)
    {
        $this->participant = $participant->load('user:id,name,email');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('meeting.host.' . $this->participant->meeting->uuid),
        ];
    }

    public function broadcastAs(): string
    {
        return 'join.requested';
    }
}
