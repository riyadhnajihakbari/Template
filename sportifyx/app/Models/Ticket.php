<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = ['event_id', 'kategori', 'harga', 'kuota', 'sold'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function availableQuota(): int
    {
        return $this->kuota - $this->sold;
    }
}