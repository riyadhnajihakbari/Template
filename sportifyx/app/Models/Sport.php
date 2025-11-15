<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sport extends Model
{
    protected $fillable = ['name', 'slug', 'icon'];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(MatchResult::class);
    }
}