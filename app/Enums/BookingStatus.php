<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Rejected = 'rejected';
    case Expired = 'expired';
    case Completed = 'completed';

    public static function blocking(): array
    {
        return [self::Pending, self::Confirmed];
    }

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Ожидает подтверждения',
            self::Confirmed => 'Подтверждена',
            self::Cancelled => 'Отменена',
            self::Rejected => 'Отклонена',
            self::Expired => 'Истекла',
            self::Completed => 'Завершена',
        };
    }
}
