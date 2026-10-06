<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BilliardTable extends Model
{
    protected $fillable = [
        'hall_id',
        'game_type_id',
        'name',
        'is_active'
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
