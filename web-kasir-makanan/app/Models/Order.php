<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'outlet_id',
        'table_number',
        'order_type', // NEW: dine_in or takeaway
        'status',
        'total_amount',
        'paid_amount',
        'payment_method',
        'created_by',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDineIn($query)
    {
        return $query->where('order_type', 'dine_in');
    }

    public function scopeTakeaway($query)
    {
        return $query->where('order_type', 'takeaway');
    }

    public function getOrderTypeLabel()
    {
        return $this->order_type === 'dine_in' ? 'Dine In' : 'Take Away';
    }

    public static function generateOrderNumber()
    {
        $date = date('Ymd');
        $lastOrder = self::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastOrder ? intval(substr($lastOrder->order_number, -4)) + 1 : 1;
        
        return 'ORD-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}