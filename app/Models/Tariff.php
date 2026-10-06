<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tariff extends Model
{
    protected $fillable = [
        'game_type_id',
        'hall_id',
        'name',
        'day_of_week',
        'start_time',
        'end_time',
        'price_per_hour',
    ];

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    public function gameType(): BelongsTo
    {
        return $this->belongsTo(GameType::class);
    }
}
