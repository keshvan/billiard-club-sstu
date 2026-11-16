<div class="page-shell">
    <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="catalog-kicker">Планирование визита</p>
            <h1 class="page-title mt-2">Тарифы</h1>
            <p class="page-description">Выберите удобное время и узнайте стоимость игры.</p>
        </div>
        @if (auth()->user()?->isAdmin())
            <button wire:click="create" class="ui-button-primary">Добавить тариф</button>
        @endif
    </div>

        @if (session('success'))
            <div class="ui-alert-success mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="ui-alert-error mb-4">{{ session('error') }}</div>
        @endif

        <div class="mb-6 flex flex-col gap-3 sm:flex-row">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Поиск по названию"
                   class="ui-input w-full sm:max-w-sm">

            <select wire:model.live="hall" class="ui-input w-full sm:max-w-xs">
                <option value="">Все залы</option>
                @foreach ($this->halls as $h)
                    <option value="{{ $h->id }}">{{ $h->name }}</option>
                @endforeach
            </select>

        </div>

        <div class="catalog-grid">
            @forelse ($tariffs as $tariff)
                <article wire:key="tariff-{{ $tariff->id }}" class="catalog-card">
                    <div class="flex items-start justify-between gap-3">
                        <p class="catalog-kicker">{{ $tariff->gameType->name }}</p>
                        <span class="rounded-full bg-[#EAF3EE] px-3 py-1 text-xs font-medium text-[#176B4D]">{{ $tariff->day_of_week?->label() ?? 'Каждый день' }}</span>
                    </div>
                    <h2 class="catalog-title"><a href="{{ route('tariffs.show', $tariff) }}" wire:navigate class="hover:text-[#176B4D]">{{ $tariff->name }}</a></h2>
                    <p class="mt-2 text-sm text-[#78827A]"><a href="{{ route('halls.show', $tariff->hall) }}" wire:navigate class="hover:text-[#176B4D]">{{ $tariff->hall->name }}</a></p>
                    <div class="catalog-meta">
                        <span>{{ substr($tariff->start_time, 0, 5) }}–{{ substr($tariff->end_time, 0, 5) }}</span>
                        <strong class="text-[#17211B]">{{ number_format($tariff->price_per_hour, 2, ',', ' ') }} ₽ / час</strong>
                    </div>
                    <div class="mt-auto flex items-center justify-between pt-5">
                        <a href="{{ route('tariffs.show', $tariff) }}" wire:navigate class="ui-link text-sm">Подробнее <span aria-hidden="true">→</span></a>
                        @if (auth()->user()?->isAdmin())
                            <div class="flex gap-3 text-xs text-[#78827A]">
                                <button wire:click="edit({{ $tariff->id }})" class="hover:text-[#176B4D]">Изменить</button>
                                <button wire:click="confirmDelete({{ $tariff->id }})" class="hover:text-[#A33F3F]">Удалить</button>
                            </div>
                        @endif
                    </div>
                </article>
            @empty
                <div class="surface-pad col-span-full text-sm text-[#78827A]">Тарифов пока нет</div>
            @endforelse
        </div>

        <div class="mt-4">{{ $tariffs->links() }}</div>

        @if (auth()->user()?->isAdmin() && $showModal)
            <x-ui.modal :title="$form->tariff ? 'Редактирование тарифа' : 'Новый тариф'" close="closeModal">
                <form wire:submit="save">
                    <div class="mb-4">
                        <label for="hall_id">Зал</label><br>
                        <select id="hall_id" wire:model="form.hall_id" class="rounded border border-gray-400 px-2 py-1">
                            <option value="">Выберите зал</option>
                            @foreach ($this->halls as $h)
                                <option value="{{ $h->id }}">{{ $h->name }}</option>
                            @endforeach
                        </select>
                        @error('form.hall_id') <div class="text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="game_type_id">Тип игры</label><br>
                        <select id="game_type_id" wire:model="form.game_type_id" class="rounded border border-gray-400 px-2 py-1">
                            <option value="">Выберите тип игры</option>
                            @foreach ($this->gameTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('form.game_type_id') <div class="text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="name">Название</label><br>
                        <input type="text" id="name" wire:model="form.name" class="rounded border border-gray-400 px-2 py-1">
                        @error('form.name') <div class="text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="day_of_week">День недели</label><br>
                        <select id="day_of_week" wire:model="form.day_of_week" class="rounded border border-gray-400 px-2 py-1">
                            <option value="">Каждый день</option>
                            @foreach (\App\Enums\DayOfWeek::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('form.day_of_week') <div class="text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="start_time">Начало</label>
                        <input type="time" id="start_time" wire:model="form.start_time" class="rounded border border-gray-400 px-2 py-1">
                        <label for="end_time">Конец</label>
                        <input type="time" id="end_time" wire:model="form.end_time" class="rounded border border-gray-400 px-2 py-1">
                        @error('form.start_time') <div class="text-red-600">{{ $message }}</div> @enderror
                        @error('form.end_time') <div class="text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price_per_hour">Цена за час</label><br>
                        <input type="number" id="price_per_hour" step="0.01" min="0" wire:model="form.price_per_hour"
                               class="rounded border border-gray-400 px-2 py-1">
                        @error('form.price_per_hour') <div class="text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="space-x-1">
                        <button type="submit" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">Сохранить</button>
                        <button type="button" wire:click="closeModal" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">Отмена</button>
                    </div>
                </form>
            </x-ui.modal>
        @endif

        @if (auth()->user()?->isAdmin() && $this->deletingTariff)
            <x-ui.modal close="cancelDelete" max-width="sm">
                <p class="mb-4">
                    Удалить тариф
                    <strong>#{{ $this->deletingTariff->id }} «{{ $this->deletingTariff->name }}»</strong>?
                </p>
                <div class="space-x-1">
                    <button wire:click="delete" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">Да, удалить</button>
                    <button wire:click="cancelDelete" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">Отмена</button>
                </div>
            </x-ui.modal>
        @endif
</div>
