<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference_id',
        'amount',
        'status',
        'payment_url',
        'response_json',
        'iniciate_request_data',
        'iniciate_response_data',
        'verify_request_data',
        'verify_response_data',
    ];

    protected $casts = [
        'amount' => 'float',
        'response_json' => 'array',
        'iniciate_request_data' => 'array',
        'iniciate_response_data' => 'array',
        'verify_request_data' => 'array',
        'verify_response_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
