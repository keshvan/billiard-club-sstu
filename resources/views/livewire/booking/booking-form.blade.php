<div class="page-shell">
    <div class="mb-7">
        <p class="catalog-kicker">Ваша следующая партия</p>
        <h1 class="page-title mt-2">Забронировать стол</h1>
        <p class="page-description">Выберите зал, стол и время. Стоимость рассчитается автоматически.</p>
    </div>

    @if (session()->has('success'))
        <div class="ui-alert-success mb-5 max-w-3xl">{{ session('success') }}</div>
    @endif

    <form wire:submit="save" class="surface-pad max-w-3xl">
        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="ui-label">Зал</label>
                <select wire:model.live="hallId" class="ui-input w-full">
                    <option value="">Выберите зал</option>
                    @foreach ($halls as $hall)
                        <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                    @endforeach
                </select>
                @error('hallId') <p class="mt-1.5 text-sm text-[#A33F3F]">{{ $message }}</p> @enderror
            </div>

            @if ($hallId)
                <div class="sm:col-span-2">
                    <label class="ui-label">Стол</label>
                    <select wire:model.live="tableId" class="ui-input w-full">
                        <option value="">Выберите стол</option>
                        @foreach ($tables as $table)
                            <option value="{{ $table->id }}">{{ $table->name }} · {{ $table->gameType->name ?? '—' }}</option>
                        @endforeach
                    </select>
                    @error('tableId') <p class="mt-1.5 text-sm text-[#A33F3F]">{{ $message }}</p> @enderror
                </div>
            @endif

            <div>
                <label class="ui-label">Дата</label>
                <input type="date" wire:model.live="bookingDate" min="{{ now()->format('Y-m-d') }}" class="ui-input w-full">
                @error('bookingDate') <p class="mt-1.5 text-sm text-[#A33F3F]">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="ui-label">Время начала</label>
                <input type="time" wire:model.live="startTime" class="ui-input w-full">
                @error('startTime') <p class="mt-1.5 text-sm text-[#A33F3F]">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="ui-label">Длительность</label>
                <div class="relative">
                    <input type="number" min="1" max="8" wire:model.live="durationHours" class="ui-input w-full pr-16">
                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm text-[#78827A]">часов</span>
                </div>
                @error('durationHours') <p class="mt-1.5 text-sm text-[#A33F3F]">{{ $message }}</p> @enderror
            </div>
        </div>

        @if ($tariffId && $totalPrice > 0)
            <div class="mt-6 flex flex-wrap items-center justify-between gap-3 rounded-lg bg-[#EAF3EE] px-4 py-4">
                <span class="text-sm font-medium text-[#526057]">Стоимость бронирования</span>
                <strong class="text-xl font-semibold text-[#176B4D]">{{ number_format($totalPrice, 2, ',', ' ') }} ₽</strong>
            </div>
        @endif

        <div class="mt-6 border-t border-[#E3E8E2] pt-5">
            <button type="submit" class="ui-button-primary w-full sm:w-auto">Подтвердить бронирование</button>
        </div>
    </form>
</div>
