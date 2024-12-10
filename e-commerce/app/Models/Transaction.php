<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_id',
        'order_id',
        'payment_type',
        'gross_amount',
        'transaction_time',
        'transaction_status',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'transaction_time' => 'datetime'
    ];
}
