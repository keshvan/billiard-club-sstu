<div class="page-shell">
    <div class="mb-7">
        <p class="catalog-kicker">Ваши визиты</p>
        <h1 class="page-title mt-2">Мои бронирования</h1>
        <p class="page-description">Здесь собраны ваши предстоящие и прошедшие игры.</p>
    </div>

    <div class="space-y-4">
        @forelse ($bookings as $booking)
            @php
                $statusStyles = match ($booking->status->value) {
                    'pending' => 'bg-[#FFF5E5] text-[#805A1B]',
                    'confirmed', 'completed' => 'bg-[#EAF3EE] text-[#176B4D]',
                    'cancelled', 'rejected', 'expired' => 'bg-[#FBECEC] text-[#A33F3F]',
                    default => 'bg-[#F2F4F1] text-[#526057]',
                };
            @endphp

            <article wire:key="my-booking-{{ $booking->id }}" class="surface-pad">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="catalog-kicker">Бронирование №{{ $booking->id }}</p>
                        <h2 class="catalog-title mt-1">{{ $booking->billiardTable?->hall?->name ?? 'Зал клуба' }}</h2>
                        <p class="mt-1 text-sm text-[#78827A]">
                            Создано {{ $booking->created_at?->format('d.m.Y в H:i') }}
                        </p>
                    </div>
                    <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusStyles }}">
                        {{ $booking->status->label() }}
                    </span>
                </div>

                <div class="mt-5 grid gap-4 border-t border-[#E3E8E2] pt-5 sm:grid-cols-3">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-[#78827A]">Время игры</p>
                        <p class="mt-1 font-medium text-[#17211B]">{{ $booking->starts_at->format('d.m.Y') }}</p>
                        <p class="text-sm text-[#526057]">
                            {{ $booking->starts_at->format('H:i') }}–{{ $booking->ends_at->format('H:i') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-[#78827A]">Стол</p>
                        <p class="mt-1 font-medium text-[#17211B]">
                            {{ $booking->billiardTable?->name ?? 'Стол не указан' }}
                        </p>
                        @if ($booking->billiardTable?->gameType)
                            <p class="text-sm text-[#526057]">{{ $booking->billiardTable->gameType->name }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-[#78827A]">Стоимость</p>
                        <p class="mt-1 text-lg font-semibold text-[#17211B]">
                            {{ number_format((float) $booking->total_price, 2, ',', ' ') }} ₽
                        </p>
                    </div>
                </div>
            </article>
        @empty
            <div class="surface-pad text-center">
                <p class="font-medium text-[#17211B]">Бронирований пока нет</p>
                <p class="mt-1 text-sm text-[#78827A]">Выберите стол и запланируйте первую игру.</p>
                <a href="{{ route('booking.form') }}" wire:navigate class="ui-button-primary mt-5">
                    Забронировать стол
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $bookings->links() }}</div>
</div>
