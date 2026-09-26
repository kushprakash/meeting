<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'phone', 'email', 'password', 'provider', 'provider_id', 'avatar', 'account_type', 'role', 'corporate_id', 'admin_id', 'is_verified', 'permissions', 'designation', 'otp_code', 'otp_expires_at', 'email_verified_at'])]
#[Hidden(['password', 'remember_token', 'otp_code'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'permissions' => 'array',
        ];
    }

    protected static function booted()
    {
        static::created(function (User $user) {
            // Automatically initialize Setting for newly created Admins and Super Admins
            if (in_array($user->role, ['super_admin', 'admin'])) {
                Setting::cloneFromSuperAdmin($user->id);
            }
        });
    }

    public function setting()
    {
        return $this->hasOne(Setting::class, 'admin_id');
    }

    public function parentAdmin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function subUsers()
    {
        return $this->hasMany(User::class, 'admin_id');
    }

    public function corporate()
    {
        return $this->belongsTo(Corporate::class, 'corporate_id');
    }

    public function hostedMeetings()
    {
        return $this->hasMany(Meeting::class, 'host_id');
    }

    public function meetingParticipations()
    {
        return $this->hasMany(MeetingParticipant::class, 'user_id');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    public function isCorporateEmployee(): bool
    {
        return $this->role === 'corporate_employee' || $this->account_type === 'corporate';
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        if (!$this->permissions) {
            return true; // Default full access for admin unless specified
        }
        return in_array($permission, $this->permissions);
    }
}
