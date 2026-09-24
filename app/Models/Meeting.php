<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'title',
        'host_id',
        'visibility',
        'approval_required',
        'status',
        'max_participants',
        'allow_audio',
        'allow_video',
        'allow_screen_share',
        'allow_chat',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'approval_required' => 'boolean',
        'allow_audio' => 'boolean',
        'allow_video' => 'boolean',
        'allow_screen_share' => 'boolean',
        'allow_chat' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function participants()
    {
        return $this->hasMany(MeetingParticipant::class);
    }

    public function isPrivate(): bool
    {
        return $this->visibility === 'private';
    }

    public function isPublic(): bool
    {
        return $this->visibility === 'public';
    }

    public function isHost(User $user): bool
    {
        return $this->host_id === $user->id;
    }
}
