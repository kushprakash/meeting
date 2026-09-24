<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corporate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'tax_id',
        'verification_status',
        'created_by_admin_id',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function employees()
    {
        return $this->hasMany(User::class, 'corporate_id');
    }

    public function creatorAdmin()
    {
        return $this->belongsTo(User::class, 'created_by_admin_id');
    }

    public function isVerified(): bool
    {
        return $this->verification_status === 'verified';
    }
}
