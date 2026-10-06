<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recharge extends Model
{
    use HasFactory;

    const STATUS_FAILED = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_PENDING = 2;

    const TYPE_MOBILE = 1;
    const TYPE_DTH = 2;
    const TYPE_BILL = 3;

    protected $fillable = [
        'user_id',
        'order_id',
        'txn_id',
        'number',
        'operator',
        'circle',
        'amount',
        'type',
        'status',
        'status_text',
        'res_text',
        'fetch_ref_id',
        'bill_number',
        'customer_name',
        'due_date',
        'response_json',
        'commission_amount',
        'commission_status',
    ];

    protected $casts = [
        'amount' => 'float',
        'commission_amount' => 'float',
        'status' => 'integer',
        'type' => 'integer',
        'commission_status' => 'boolean',
        'response_json' => 'array',
    ];

    /**
     * Get the user that owns the recharge transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
