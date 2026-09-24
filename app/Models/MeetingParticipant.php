<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'user_id',
        'email',
        'role',
        'status',
        'invited_at',
        'approved_at',
        'rejected_at',
        'joined_at',
        'left_at',
        'approved_by',
    ];

    protected $casts = [
        'invited_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved' || $this->status === 'joined';
    }

    public function isBlocked(): bool
    {
        return $this->status === 'blocked' || $this->status === 'removed';
    }
}
