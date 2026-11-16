<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-800">Личный кабинет</p>
                <h1 class="mt-2 text-2xl font-semibold">Рады видеть вас, {{ auth()->user()->name }}</h1>
            </div>
            <a href="{{ route('booking.form') }}" wire:navigate class="ui-button-primary">Забронировать стол</a>
        </div>
    </x-slot>
    <div class="page-shell pt-6">
        <div class="surface-pad">
            <h2 class="text-lg font-semibold">Начните с выбора зала</h2>
            <p class="mt-2 text-sm text-slate-500">Посмотрите доступные залы, столы и тарифы клуба.</p>
            <div class="mt-5 flex flex-wrap gap-3">
                <a href="{{ route('halls.index') }}" wire:navigate class="ui-button-secondary">Залы</a>
                <a href="{{ route('billiard-tables.index') }}" wire:navigate class="ui-button-secondary">Столы</a>
                <a href="{{ route('tariffs.index') }}" wire:navigate class="ui-button-secondary">Тарифы</a>
            </div>
        </div>
    </div>
</x-app-layout>
