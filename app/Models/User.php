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

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean',
        'permissions' => 'array',
    ];

    protected $appends = ['wallet_balance', 'balance'];

    public function passbooks()
    {
        return $this->hasMany(Passbook::class, 'user_id')->latest('id');
    }

    public function getWalletBalanceAttribute(): float
    {
        $lastPassbook = Passbook::where('user_id', $this->id)->latest('id')->first();

        return $lastPassbook ? (float) $lastPassbook->balance : 0.00;
    }

    public function getBalanceAttribute(): float
    {
        return $this->getWalletBalanceAttribute();
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
        if (! $this->permissions) {
            return true; // Default full access for admin unless specified
        }

        return in_array($permission, $this->permissions);
    }
}
