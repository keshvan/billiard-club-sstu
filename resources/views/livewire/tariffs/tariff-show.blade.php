<div class="py-6">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mb-4 text-2xl font-bold">{{ $tariff->name }} <span class="text-gray-500">#{{ $tariff->id }}</span></h1>

        <dl class="mb-4 grid grid-cols-[max-content_1fr] gap-x-6 gap-y-1">
            <dt class="font-semibold">Зал</dt>
            <dd>{{ $tariff->hall->name }}</dd>

            <dt class="font-semibold">Тип игры</dt>
            <dd>{{ $tariff->gameType->name }}</dd>

            <dt class="font-semibold">День</dt>
            <dd>{{ $tariff->day_of_week?->label() ?? 'Каждый день' }}</dd>

            <dt class="font-semibold">Время</dt>
            <dd>{{ substr($tariff->start_time, 0, 5) }}–{{ substr($tariff->end_time, 0, 5) }}</dd>

            <dt class="font-semibold">Цена за час</dt>
            <dd>{{ number_format($tariff->price_per_hour, 2, ',', ' ') }}</dd>
        </dl>

        <a href="{{ route('tariffs.index') }}" wire:navigate
           class="text-blue-600 underline hover:text-blue-800">К списку</a>
    </div>
</div>
