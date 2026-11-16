<x-app-layout>
    <main class="page-shell">
        <section class="relative overflow-hidden rounded-2xl bg-[#123A2D] px-6 py-12 text-white sm:px-10 sm:py-16 lg:px-14">
            <div class="absolute -right-16 -top-24 h-72 w-72 rounded-full border border-white/10"></div>
            <div class="absolute -right-4 -top-12 h-48 w-48 rounded-full border border-white/10"></div>
            <div class="relative max-w-2xl">
                <p class="mb-4 text-xs font-semibold uppercase tracking-[0.22em] text-[#D8E8DF]">Клуб · игра · встреча</p>
                <h1 class="max-w-xl text-4xl font-semibold leading-tight text-white sm:text-5xl">Время для хорошей партии</h1>
                <p class="mt-5 max-w-lg text-base leading-7 text-[#D8E8DF]">Выберите зал и стол, посмотрите тарифы и забронируйте удобное время.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('halls.index') }}" wire:navigate class="ui-button rounded-lg bg-white px-5 py-3 text-sm font-semibold text-[#123A2D] hover:bg-[#EAF3EE] focus:ring-white">Выбрать зал</a>
                    @auth
                        <a href="{{ route('booking.form') }}" wire:navigate class="ui-button rounded-lg border border-white/25 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10 focus:ring-white">Забронировать стол</a>
                    @else
                        <a href="{{ route('register') }}" wire:navigate class="ui-button rounded-lg border border-white/25 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10 focus:ring-white">Создать аккаунт</a>
                    @endauth
                </div>
            </div>
        </section>

        <section class="mt-10 grid gap-4 sm:grid-cols-3">
            <a href="{{ route('halls.index') }}" wire:navigate class="surface-pad group transition hover:border-[#C7D9CE]">
                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-800">01 / Пространство</span>
                <h2 class="mt-3 text-lg font-semibold">Залы</h2>
                <p class="mt-2 text-sm leading-6 text-[#78827A]">Найдите подходящий зал для игры и отдыха.</p>
                <span class="mt-5 inline-block text-sm font-medium text-emerald-800">Смотреть залы →</span>
            </a>
            <a href="{{ route('billiard-tables.index') }}" wire:navigate class="surface-pad group transition hover:border-[#C7D9CE]">
                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-800">02 / Игра</span>
                <h2 class="mt-3 text-lg font-semibold">Столы</h2>
                <p class="mt-2 text-sm leading-6 text-[#78827A]">Посмотрите доступные столы и типы игры.</p>
                <span class="mt-5 inline-block text-sm font-medium text-emerald-800">Выбрать стол →</span>
            </a>
            <a href="{{ route('tariffs.index') }}" wire:navigate class="surface-pad group transition hover:border-[#C7D9CE]">
                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-800">03 / Планирование</span>
                <h2 class="mt-3 text-lg font-semibold">Тарифы</h2>
                <p class="mt-2 text-sm leading-6 text-[#78827A]">Сравните расписание и стоимость игры.</p>
                <span class="mt-5 inline-block text-sm font-medium text-emerald-800">Изучить тарифы →</span>
            </a>
        </section>
    </main>
</x-app-layout>
