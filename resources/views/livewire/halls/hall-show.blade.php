<div>
    <h1>{{ $hall->name }}</h1>
    <p>{{ $hall->description ?? 'Описание отсутствует' }}</p>

    <h2>Столы</h2>
    <ul>
        @forelse ($hall->billiardTables as $table)
            <li>{{ $table->name ?? ('Стол #' . $table->id) }}</li>
        @empty
            <li>Нет столов</li>
        @endforelse
    </ul>

    <h2>Тарифы</h2>
    <ul>
        @forelse ($hall->tariffs as $tariff)
            <li>{{ $tariff->name ?? ('Тариф #' . $tariff->id) }}</li>
        @empty
            <li>Нет тарифов</li>
        @endforelse
    </ul>

    <a href="{{ route('halls.index') }}" wire:navigate>К списку</a>
    <a href="{{ route('billiard-tables.index', ['hall' => $hall->id]) }}" wire:navigate>Все столы зала</a>
    <a href="{{ route('tariffs.index', ['hall' => $hall->id]) }}" wire:navigate>Все тарифы зала</a>
</div>
