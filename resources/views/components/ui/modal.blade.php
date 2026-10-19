@props([
    'title' => null,
    'close' => 'closeModal', // имя Livewire-метода, который закрывает модалку
    'maxWidth' => 'md',
])

@php
    $maxWidthClass = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
    ][$maxWidth] ?? 'max-w-md';
@endphp

<div
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    wire:click.self="{{ $close }}"
    wire:keydown.escape.window="{{ $close }}"
>
    <div {{ $attributes->class(['w-full rounded bg-white p-6 shadow', $maxWidthClass]) }}>
        @if ($title)
            <h2 class="mb-4 text-xl font-semibold">{{ $title }}</h2>
        @endif

        {{ $slot }}
    </div>
</div>
