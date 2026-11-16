<div class="page-shell">
    <a href="{{ route('halls.index') }}" wire:navigate class="ui-link text-sm">← Все залы</a>
    <section class="surface-pad mt-5">
        <p class="catalog-kicker">Пространство клуба</p>
        <h1 class="page-title mt-2">{{ $hall->name }}</h1>
        <p class="page-description mt-3">{{ $hall->description ?? 'Здесь вас ждёт комфортная игра и приятная атмосфера.' }}</p>
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('billiard-tables.index', ['hall' => $hall->id]) }}" wire:navigate class="ui-button-primary">Посмотреть столы</a>
            <a href="{{ route('tariffs.index', ['hall' => $hall->id]) }}" wire:navigate class="ui-button-secondary">Посмотреть тарифы</a>
        </div>
    </section>

    <div class="mt-8 grid gap-5 md:grid-cols-2">
        <section class="surface-pad">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Столы</h2>
                <span class="rounded-full bg-[#EAF3EE] px-3 py-1 text-xs font-medium text-[#176B4D]">{{ $hall->billiardTables->count() }}</span>
            </div>
            <ul class="mt-4 divide-y divide-[#E3E8E2]">
                @forelse ($hall->billiardTables as $table)
                    <li class="py-3 text-sm text-[#526057]">{{ $table->name ?? ('Стол #' . $table->id) }}</li>
                @empty
                    <li class="py-3 text-sm text-[#78827A]">В этом зале пока нет столов.</li>
                @endforelse
            </ul>
        </section>
        <section class="surface-pad">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Тарифы</h2>
                <span class="rounded-full bg-[#EAF3EE] px-3 py-1 text-xs font-medium text-[#176B4D]">{{ $hall->tariffs->count() }}</span>
            </div>
            <ul class="mt-4 divide-y divide-[#E3E8E2]">
                @forelse ($hall->tariffs as $tariff)
                    <li class="py-3 text-sm text-[#526057]">{{ $tariff->name ?? ('Тариф #' . $tariff->id) }}</li>
                @empty
                    <li class="py-3 text-sm text-[#78827A]">Тарифы пока не добавлены.</li>
                @endforelse
            </ul>
        </section>
    </div>
</div>
