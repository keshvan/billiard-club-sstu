<div class="py-6">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mb-2 text-2xl font-bold">{{ $billiardTable->name }}</h1>
        <p class="mb-4">Активен: {{ $billiardTable->is_active ? 'Да' : 'Нет' }}</p>

        <h2 class="mt-4 text-lg font-semibold">Тип игры</h2>
        <p>{{ $billiardTable->gameType->name }}</p>

        <h2 class="mt-4 text-lg font-semibold">Зал</h2>
        <p class="mb-4">{{ $billiardTable->hall->name }}</p>

        <a href="{{ route('billiard-tables.index') }}" wire:navigate
           class="text-blue-600 underline hover:text-blue-800">К списку</a>
    </div>
</div>
