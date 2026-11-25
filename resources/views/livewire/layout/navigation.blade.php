<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="border-b border-stone-200 bg-white">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-8">
            <a href="{{ route('halls.index') }}" wire:navigate class="flex items-center gap-3 text-slate-900">
                <x-application-logo class="h-9 w-9 fill-current text-emerald-800" />
                <span class="hidden text-sm font-semibold sm:inline">Бильярдный клуб</span>
            </a>
            <div class="hidden items-center gap-6 text-sm sm:flex">
                <a href="{{ route('halls.index') }}" wire:navigate class="{{ request()->routeIs('halls.*') ? 'text-emerald-800' : 'text-slate-600' }} hover:text-emerald-900">Залы</a>
                <a href="{{ route('billiard-tables.index') }}" wire:navigate class="{{ request()->routeIs('billiard-tables.*') ? 'text-emerald-800' : 'text-slate-600' }} hover:text-emerald-900">Столы</a>
                <a href="{{ route('tariffs.index') }}" wire:navigate class="{{ request()->routeIs('tariffs.*') ? 'text-emerald-800' : 'text-slate-600' }} hover:text-emerald-900">Тарифы</a>
            </div>
        </div>

        <div class="hidden items-center gap-3 sm:flex">
            @auth
                <a href="{{ route('booking.form') }}" wire:navigate class="ui-button-primary">Забронировать</a>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-stone-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-700">
                            {{ auth()->user()->name }}
                            <span class="ms-1 text-slate-400">⌄</span>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('my-bookings.index')" wire:navigate>Мои бронирования</x-dropdown-link>
                        <x-dropdown-link :href="route('profile')" wire:navigate>Профиль</x-dropdown-link>
                        <button wire:click="logout" class="w-full text-start"><x-dropdown-link>Выйти</x-dropdown-link></button>
                    </x-slot>
                </x-dropdown>
            @else
                <a href="{{ route('login') }}" wire:navigate class="text-sm font-medium text-slate-600 hover:text-slate-900">Войти</a>
                <a href="{{ route('register') }}" wire:navigate class="ui-button-primary">Регистрация</a>
            @endauth
        </div>

        <button @click="open = !open" class="rounded-lg p-2 text-slate-600 hover:bg-stone-100 focus:outline-none focus:ring-2 focus:ring-emerald-700 sm:hidden" aria-label="Открыть меню">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 6h16M4 12h16M4 18h16" /></svg>
        </button>
    </div>

    <div x-show="open" x-cloak class="border-t border-stone-200 px-4 py-4 sm:hidden">
        <div class="flex flex-col gap-3 text-sm">
            <a href="{{ route('halls.index') }}" wire:navigate class="text-slate-700">Залы</a>
            <a href="{{ route('billiard-tables.index') }}" wire:navigate class="text-slate-700">Столы</a>
            <a href="{{ route('tariffs.index') }}" wire:navigate class="text-slate-700">Тарифы</a>
            @auth
                <a href="{{ route('booking.form') }}" wire:navigate class="ui-button-primary mt-1">Забронировать</a>
                <a href="{{ route('my-bookings.index') }}" wire:navigate class="text-slate-700">Мои бронирования</a>
                <a href="{{ route('profile') }}" wire:navigate class="text-slate-700">Профиль · {{ auth()->user()->name }}</a>
                <button wire:click="logout" class="text-left text-slate-600">Выйти</button>
            @else
                <a href="{{ route('login') }}" wire:navigate class="text-slate-700">Войти</a>
                <a href="{{ route('register') }}" wire:navigate class="text-slate-700">Регистрация</a>
            @endauth
        </div>
    </div>
</nav>
