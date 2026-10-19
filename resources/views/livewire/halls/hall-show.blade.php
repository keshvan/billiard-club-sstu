<div class="py-6">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mb-2 text-2xl font-bold">{{ $hall->name }}</h1>
        <p class="mb-4">{{ $hall->description ?? 'Описание отсутствует' }}</p>

        <h2 class="mt-4 text-lg font-semibold">Столы</h2>
        <ul class="mb-4 list-disc pl-6">
            @forelse ($hall->billiardTables as $table)
                <li>{{ $table->name ?? ('Стол #' . $table->id) }}</li>
            @empty
                <li>Нет столов</li>
            @endforelse
        </ul>

        <h2 class="mt-4 text-lg font-semibold">Тарифы</h2>
        <ul class="mb-4 list-disc pl-6">
            @forelse ($hall->tariffs as $tariff)
                <li>{{ $tariff->name ?? ('Тариф #' . $tariff->id) }}</li>
            @empty
                <li>Нет тарифов</li>
            @endforelse
        </ul>

        <div class="space-x-4">
            <a href="{{ route('halls.index') }}" wire:navigate
               class="text-blue-600 underline hover:text-blue-800">К списку</a>
            <a href="{{ route('billiard-tables.index', ['hall' => $hall->id]) }}" wire:navigate
               class="text-blue-600 underline hover:text-blue-800">Все столы зала</a>
            <a href="{{ route('tariffs.index', ['hall' => $hall->id]) }}" wire:navigate
               class="text-blue-600 underline hover:text-blue-800">Все тарифы зала</a>
        </div>
    </div>
</div>
