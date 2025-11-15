<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    protected $fillable = [
        'name', 'description', 'category', 'price', 'discount', 'stock', 'image'
    ];

    public function getFinalPriceAttribute(): float
    {
        return $this->price - ($this->price * $this->discount / 100);
    }
}