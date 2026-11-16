<div class="page-shell">
    <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="catalog-kicker">Пространство клуба</p>
            <h1 class="page-title mt-2">Залы</h1>
            <p class="page-description">Выберите зал, который подойдёт для вашей игры и компании.</p>
        </div>
        @if (auth()->user()?->isAdmin())
            <button wire:click="create" class="ui-button-primary">Добавить зал</button>
        @endif
    </div>

        @if (session('success'))
            <div class="ui-alert-success mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="ui-alert-error mb-4">{{ session('error') }}</div>
        @endif

        <div class="mb-6">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Поиск по названию"
                   class="ui-input w-full sm:max-w-sm">
        </div>

        <div class="catalog-grid">
            @forelse ($halls as $hall)
                <article wire:key="hall-{{ $hall->id }}" class="catalog-card">
                    <p class="catalog-kicker">Зал клуба</p>
                    <h2 class="catalog-title"><a href="{{ route('halls.show', $hall) }}" wire:navigate class="hover:text-[#176B4D]">{{ $hall->name }}</a></h2>
                    <p class="catalog-copy">{{ $hall->description ?: 'Уютное пространство для игры и отдыха.' }}</p>
                    <div class="catalog-meta">
                        <span>Столы: {{ $hall->billiard_tables_count }}</span>
                        <span>Тарифы: {{ $hall->tariffs_count }}</span>
                    </div>
                    <div class="mt-auto flex items-center justify-between pt-5">
                        <a href="{{ route('halls.show', $hall) }}" wire:navigate class="ui-link text-sm">Подробнее <span aria-hidden="true">→</span></a>
                        @if (auth()->user()?->isAdmin())
                            <div class="flex gap-3 text-xs text-[#78827A]">
                                <button wire:click="edit({{ $hall->id }})" class="hover:text-[#176B4D]">Изменить</button>
                                <button wire:click="confirmDelete({{ $hall->id }})" class="hover:text-[#A33F3F]">Удалить</button>
                            </div>
                        @endif
                    </div>
                </article>
            @empty
                <div class="surface-pad col-span-full text-sm text-[#78827A]">Залов пока нет</div>
            @endforelse
        </div>

        <div class="mt-4">{{ $halls->links() }}</div>

        @if (auth()->user()?->isAdmin() && $showModal)
            <x-ui.modal :title="$form->hall ? 'Редактирование зала' : 'Новый зал'" close="closeModal">
                <form wire:submit="save">
                    <div class="mb-4">
                        <label for="name" class="ui-label">Название</label>
                        <input type="text" id="name" wire:model="form.name" class="ui-input w-full">
                        @error('form.name') <div class="text-sm text-[#A33F3F]">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="ui-label">Описание</label>
                        <textarea id="description" rows="5" wire:model="form.description" class="ui-input w-full"></textarea>
                        @error('form.description') <div class="text-sm text-[#A33F3F]">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button type="submit" class="ui-button-primary">Сохранить</button>
                        <button type="button" wire:click="closeModal" class="ui-button-secondary">Отмена</button>
                    </div>
                </form>
            </x-ui.modal>
        @endif

        @if (auth()->user()?->isAdmin() && $this->deletingHall)
            <x-ui.modal close="cancelDelete" max-width="sm">
                <p class="mb-4">
                    Удалить зал
                    <strong>#{{ $this->deletingHall->id }} «{{ $this->deletingHall->name }}»</strong>?
                </p>
                <div class="flex flex-wrap gap-2">
                    <button wire:click="delete" class="ui-button-danger">Да, удалить</button>
                    <button wire:click="cancelDelete" class="ui-button-secondary">Отмена</button>
                </div>
            </x-ui.modal>
        @endif
</div>
