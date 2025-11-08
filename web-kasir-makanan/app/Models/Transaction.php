<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'gateway_ref',
        'status',
        'synced',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'synced' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
