<div>
    <h1>{{ $tariff->id }}</h1>
    <h1>{{ $tariff->name }}</h1>
    <h1>{{ $tariff->hall->name }}</h1>
    <h1>{{ $tariff->gameType->name }}</h1>
    <h1>{{ \App\Models\Tariff::DAYS[$tariff->day_of_week] ?? 'Каждый день' }}</h1>
    <h1>{{ substr($tariff->start_time, 0, 5) }}–{{ substr($tariff->end_time, 0, 5) }}</h1>
    <h1>{{ number_format($tariff->price_per_hour, 2, ',', ' ') }}</h1>

    <a href="{{ route('tariffs.index') }}" wire:navigate>К списку</a>
</div>
