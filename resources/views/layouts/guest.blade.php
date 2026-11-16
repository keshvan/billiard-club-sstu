<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen flex-col items-center justify-center px-4 py-10 sm:px-6">
            <a href="/" wire:navigate class="mb-6 flex items-center gap-3 text-slate-900">
                    <x-application-logo class="h-10 w-10 fill-current text-emerald-800" />
                    <span class="text-lg font-semibold">Бильярдный клуб</span>
                </a>

            <div class="surface w-full max-w-md overflow-hidden p-6 shadow-sm sm:p-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
