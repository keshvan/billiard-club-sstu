<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hall extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function billiardTables(): HasMany
    {
        return $this->hasMany(BilliardTable::class);
    }

    public function tariffs(): HasMany
    {
        return $this->hasMany(Tariff::class);
    }
}
