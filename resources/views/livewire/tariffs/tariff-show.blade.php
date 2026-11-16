<div class="page-shell">
    <a href="{{ route('tariffs.index') }}" wire:navigate class="ui-link text-sm">← Все тарифы</a>
    <section class="surface-pad mt-5 max-w-3xl">
        <p class="catalog-kicker">{{ $tariff->gameType->name }}</p>
        <h1 class="page-title mt-2">{{ $tariff->name }}</h1>
        <p class="mt-2 text-sm text-[#78827A]">Зал: <a href="{{ route('halls.show', $tariff->hall) }}" wire:navigate class="ui-link">{{ $tariff->hall->name }}</a></p>
        <div class="mt-7 grid gap-4 border-t border-[#E3E8E2] pt-6 sm:grid-cols-2">
            <div><p class="text-sm text-[#78827A]">День</p><p class="mt-1 font-medium">{{ $tariff->day_of_week?->label() ?? 'Каждый день' }}</p></div>
            <div><p class="text-sm text-[#78827A]">Время игры</p><p class="mt-1 font-medium">{{ substr($tariff->start_time, 0, 5) }}–{{ substr($tariff->end_time, 0, 5) }}</p></div>
            <div class="sm:col-span-2"><p class="text-sm text-[#78827A]">Стоимость</p><p class="mt-1 text-2xl font-semibold text-[#176B4D]">{{ number_format($tariff->price_per_hour, 2, ',', ' ') }} ₽ <span class="text-sm font-normal text-[#78827A]">за час</span></p></div>
        </div>
        @auth
            <a href="{{ route('booking.form') }}" wire:navigate class="ui-button-primary mt-7">Забронировать стол</a>
        @else
            <a href="{{ route('login') }}" wire:navigate class="ui-button-primary mt-7">Войти, чтобы забронировать</a>
        @endauth
    </section>
</div>
