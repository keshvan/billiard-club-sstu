<div class="page-shell">
    <a href="{{ route('billiard-tables.index') }}" wire:navigate class="ui-link text-sm">← Все столы</a>
    <section class="surface-pad mt-5 max-w-3xl">
        <div class="flex flex-wrap items-center gap-3">
            <p class="catalog-kicker">{{ $billiardTable->gameType->name }}</p>
            <span class="rounded-full px-3 py-1 text-xs font-medium {{ $billiardTable->is_active ? 'bg-[#EAF3EE] text-[#176B4D]' : 'bg-[#F7F8F5] text-[#78827A]' }}">{{ $billiardTable->is_active ? 'Доступен' : 'Сейчас недоступен' }}</span>
        </div>
        <h1 class="page-title mt-3">{{ $billiardTable->name }}</h1>
        <p class="mt-3 text-sm text-[#78827A]">Зал: <a href="{{ route('halls.show', $billiardTable->hall) }}" wire:navigate class="ui-link">{{ $billiardTable->hall->name }}</a></p>
        @if ($billiardTable->is_active)
            <a href="{{ route('booking.form') }}" wire:navigate class="ui-button-primary mt-7">Забронировать стол</a>
        @else
            <p class="ui-alert-error mt-7">Стол временно недоступен для бронирования.</p>
        @endif
    </section>
</div>
