<div class="page-shell">
    <div class="mb-7">
        <p class="catalog-kicker">Управление клубом</p>
        <h1 class="page-title mt-2">Бронирования</h1>
        <p class="page-description">Проверяйте заявки гостей и подтверждайте свободное время.</p>
    </div>

    @if (session('success'))
        <div role="status" class="ui-alert-success mb-5">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div role="alert" class="ui-alert-error mb-5">{{ session('error') }}</div>
    @endif

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <label for="booking-status" class="sr-only">Фильтр по статусу</label>
        <select id="booking-status" wire:model.live="status" class="ui-input w-full sm:max-w-xs">
            <option value="">Все статусы</option>
            <option value="pending">Ожидает подтверждения</option>
            <option value="confirmed">Подтверждена</option>
            <option value="cancelled">Отменена</option>
            <option value="rejected">Отклонена</option>
            <option value="expired">Истекла</option>
            <option value="completed">Завершена</option>
        </select>
        <p class="text-sm text-[#78827A]">Найдено: {{ $bookings->total() }}</p>
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

            <article wire:key="booking-{{ $booking->id }}" class="surface-pad">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="catalog-kicker">Заявка №{{ $booking->id }}</p>
                        <h2 class="catalog-title mt-1">{{ $booking->guest_name ?: $booking->user?->name ?: 'Гость' }}</h2>
                        <p class="mt-1 text-sm text-[#78827A]">
                            Создана {{ $booking->created_at?->format('d.m.Y в H:i') }}
                        </p>
                    </div>
                    <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusStyles }}">
                        {{ $booking->status->label() }}
                    </span>
                </div>

                <div class="mt-5 grid gap-4 border-t border-[#E3E8E2] pt-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-[#78827A]">Время игры</p>
                        <p class="mt-1 font-medium text-[#17211B]">
                            {{ $booking->starts_at->format('d.m.Y') }}
                        </p>
                        <p class="text-sm text-[#526057]">
                            {{ $booking->starts_at->format('H:i') }}–{{ $booking->ends_at->format('H:i') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-[#78827A]">Стол</p>
                        <p class="mt-1 font-medium text-[#17211B]">{{ $booking->billiardTable?->name ?? 'Стол не указан' }}</p>
                        <p class="text-sm text-[#526057]">
                            {{ $booking->billiardTable?->hall?->name ?? 'Зал не указан' }}
                            @if ($booking->billiardTable?->gameType)
                                · {{ $booking->billiardTable->gameType->name }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-[#78827A]">Контакты</p>
                        @if ($booking->guest_phone)
                            <p class="mt-1 text-sm text-[#17211B]">{{ $booking->guest_phone }}</p>
                        @endif
                        @if ($booking->guest_email ?: $booking->user?->email)
                            <p class="mt-1 break-all text-sm text-[#526057]">{{ $booking->guest_email ?: $booking->user?->email }}</p>
                        @endif
                        @if (! $booking->guest_phone && ! $booking->guest_email && ! $booking->user?->email)
                            <p class="mt-1 text-sm text-[#78827A]">Контакты не указаны</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-[#78827A]">Стоимость</p>
                        <p class="mt-1 text-lg font-semibold text-[#17211B]">
                            {{ number_format((float) $booking->total_price, 2, ',', ' ') }} ₽
                        </p>
                    </div>
                </div>

                @if ($booking->comment)
                    <div class="mt-4 rounded-lg bg-[#F7F8F5] px-4 py-3">
                        <p class="text-xs font-medium uppercase tracking-wide text-[#78827A]">Комментарий гостя</p>
                        <p class="mt-1 whitespace-pre-line text-sm text-[#526057]">{{ $booking->comment }}</p>
                    </div>
                @endif

                @if ($booking->status->value === 'pending')
                    <div class="mt-5 flex flex-wrap gap-2 border-t border-[#E3E8E2] pt-4">
                        <button type="button" wire:click="approve({{ $booking->id }})" wire:loading.attr="disabled" wire:target="approve({{ $booking->id }})" class="ui-button-primary disabled:cursor-wait disabled:opacity-60">
                            Подтвердить
                        </button>
                        <button type="button" wire:click="reject({{ $booking->id }})" wire:loading.attr="disabled" wire:target="reject({{ $booking->id }})" class="ui-button-danger disabled:cursor-wait disabled:opacity-60">
                            Отклонить
                        </button>
                    </div>
                @endif
            </article>
        @empty
            <div class="surface-pad text-center">
                <p class="font-medium text-[#17211B]">Бронирований пока нет</p>
                <p class="mt-1 text-sm text-[#78827A]">Когда появятся заявки, они будут отображаться здесь.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $bookings->links() }}</div>
</div>
