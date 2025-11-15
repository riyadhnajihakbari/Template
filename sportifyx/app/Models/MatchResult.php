<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchResult extends Model
{
    protected $table = 'matches';
    
    protected $fillable = [
        'sport_id', 'team_a', 'team_b', 'score_a', 'score_b',
        'tanggal', 'lokasi', 'highlight_url'
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }
}