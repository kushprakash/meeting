<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passbook extends Model
{
    use HasFactory;

    protected $table = 'passbooks';

    protected $fillable = [
        'user_id',
        'details',
        'type',
        'pre_balance',
        'amount',
        'balance',
    ];

    protected $casts = [
        'pre_balance' => 'float',
        'amount' => 'float',
        'balance' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
