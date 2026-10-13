<div>
    <h1>{{ $billiardTable->name }}</h1>
    <p>{{ $billiardTable->is_active ? 'Да' : 'Нет' }}</p>

    <h2>Тип игры</h2>
    {{ $billiardTable->gameType->name }}

    <h2>Зал</h2>
    {{ $billiardTable->hall->name }}

    <a href="{{ route('billiard-tables.index') }}" wire:navigate>К списку</a>
</div>
