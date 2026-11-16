<div class="page-shell">
    <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="catalog-kicker">Выбор игры</p>
            <h1 class="page-title mt-2">Бильярдные столы</h1>
            <p class="page-description">Найдите стол и тип игры для следующей партии.</p>
        </div>
        @if (auth()->user()?->isAdmin())
            <button wire:click="create" class="ui-button-primary">Добавить стол</button>
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
            @forelse ($tables as $table)
                <article wire:key="table-{{ $table->id }}" class="catalog-card">
                    <div class="flex items-start justify-between gap-3">
                        <p class="catalog-kicker">{{ $table->gameType->name }}</p>
                        <span class="rounded-full px-3 py-1 text-xs font-medium {{ $table->is_active ? 'bg-[#EAF3EE] text-[#176B4D]' : 'bg-[#F7F8F5] text-[#78827A]' }}">{{ $table->is_active ? 'Доступен' : 'Недоступен' }}</span>
                    </div>
                    <h2 class="catalog-title"><a href="{{ route('billiard-tables.show', $table) }}" wire:navigate class="hover:text-[#176B4D]">{{ $table->name }}</a></h2>
                    <p class="mt-2 text-sm text-[#78827A]"><a href="{{ route('halls.show', $table->hall) }}" wire:navigate class="hover:text-[#176B4D]">{{ $table->hall->name }}</a></p>
                    <div class="mt-auto flex items-center justify-between border-t border-[#E3E8E2] pt-4 mt-5">
                        <a href="{{ route('billiard-tables.show', $table) }}" wire:navigate class="ui-link text-sm">Подробнее <span aria-hidden="true">→</span></a>
                        @if (auth()->user()?->isAdmin())
                            <div class="flex gap-3 text-xs text-[#78827A]">
                                <button wire:click="edit({{ $table->id }})" class="hover:text-[#176B4D]">Изменить</button>
                                <button wire:click="confirmDelete({{ $table->id }})" class="hover:text-[#A33F3F]">Удалить</button>
                            </div>
                        @endif
                    </div>
                </article>
            @empty
                <div class="surface-pad col-span-full text-sm text-[#78827A]">Столов пока нет</div>
            @endforelse
        </div>

        <div class="mt-4">{{ $tables->links() }}</div>

        @if (auth()->user()?->isAdmin() && $showModal)
            <x-ui.modal :title="$form->billiardTable ? 'Редактирование стола' : 'Новый стол'" close="closeModal">
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
                        <label>
                            <input type="checkbox" wire:model="form.is_active" class="rounded border-gray-400"> Активен
                        </label>
                        @error('form.is_active') <div class="text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="space-x-1">
                        <button type="submit" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">Сохранить</button>
                        <button type="button" wire:click="closeModal" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">Отмена</button>
                    </div>
                </form>
            </x-ui.modal>
        @endif

        @if (auth()->user()?->isAdmin() && $this->deletingTable)
            <x-ui.modal close="cancelDelete" max-width="sm">
                <p class="mb-4">
                    Удалить стол
                    <strong>#{{ $this->deletingTable->id }} «{{ $this->deletingTable->name }}»</strong>?
                </p>
                <div class="space-x-1">
                    <button wire:click="delete" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">Да, удалить</button>
                    <button wire:click="cancelDelete" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">Отмена</button>
                </div>
            </x-ui.modal>
        @endif
</div>
