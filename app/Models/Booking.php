<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'billiard_table_id', 'user_id',
        'guest_name', 'guest_phone', 'guest_email',
        'starts_at', 'ends_at',
        'status', 'expires_at', 'confirmed_at', 'cancelled_at',
        'total_price', 'comment',
    ];

    protected function casts(): array
    {
        return [
            'status' => BookingStatus::class,
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'expires_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'price_breakdown' => 'array',
            'total_price' => 'decimal:2',
        ];
    }

    public function billiardTable(): BelongsTo
    {
        return $this->belongsTo(BilliardTable::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
