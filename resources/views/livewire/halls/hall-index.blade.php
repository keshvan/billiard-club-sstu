<div class="py-6">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mb-4 text-2xl font-bold">Залы</h1>

        @if (session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif

        <div class="mb-4 flex flex-wrap gap-2">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Поиск по названию"
                   class="rounded border border-gray-400 px-2 py-1">
            <button wire:click="create" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">
                Добавить зал
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-400">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="border border-gray-400 p-1.5">ID</th>
                        <th class="border border-gray-400 p-1.5">Название</th>
                        <th class="border border-gray-400 p-1.5">Описание</th>
                        <th class="border border-gray-400 p-1.5">Столов</th>
                        <th class="border border-gray-400 p-1.5">Тарифов</th>
                        <th class="border border-gray-400 p-1.5">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($halls as $hall)
                        <tr wire:key="hall-{{ $hall->id }}">
                            <td class="border border-gray-400 p-1.5">{{ $hall->id }}</td>
                            <td class="border border-gray-400 p-1.5">
                                <a href="{{ route('halls.show', $hall) }}" wire:navigate
                                   class="text-blue-600 underline hover:text-blue-800">{{ $hall->name }}</a>
                            </td>
                            <td class="border border-gray-400 p-1.5">{{ \Illuminate\Support\Str::limit($hall->description, 60) }}</td>
                            <td class="border border-gray-400 p-1.5">{{ $hall->billiard_tables_count }}</td>
                            <td class="border border-gray-400 p-1.5">{{ $hall->tariffs_count }}</td>
                            <td class="space-x-1 border border-gray-400 p-1.5">
                                <button wire:click="edit({{ $hall->id }})"
                                        class="rounded border border-gray-400 bg-gray-100 px-2 py-0.5 hover:bg-gray-200">Изменить</button>
                                <button wire:click="confirmDelete({{ $hall->id }})"
                                        class="rounded border border-gray-400 bg-gray-100 px-2 py-0.5 hover:bg-gray-200">Удалить</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="border border-gray-400 p-1.5">Залов пока нет</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $halls->links() }}</div>

        @if ($showModal)
            <x-ui.modal :title="$form->hall ? 'Редактирование зала' : 'Новый зал'" close="closeModal">
                <form wire:submit="save">
                    <div class="mb-4">
                        <label for="name">Название</label><br>
                        <input type="text" id="name" wire:model="form.name" class="rounded border border-gray-400 px-2 py-1">
                        @error('form.name') <div class="text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description">Описание</label><br>
                        <textarea id="description" rows="5" wire:model="form.description"
                                  class="w-full rounded border border-gray-400 px-2 py-1"></textarea>
                        @error('form.description') <div class="text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="space-x-1">
                        <button type="submit" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">Сохранить</button>
                        <button type="button" wire:click="closeModal" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">Отмена</button>
                    </div>
                </form>
            </x-ui.modal>
        @endif

        @if ($this->deletingHall)
            <x-ui.modal close="cancelDelete" max-width="sm">
                <p class="mb-4">
                    Удалить зал
                    <strong>#{{ $this->deletingHall->id }} «{{ $this->deletingHall->name }}»</strong>?
                </p>
                <div class="space-x-1">
                    <button wire:click="delete" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">Да, удалить</button>
                    <button wire:click="cancelDelete" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">Отмена</button>
                </div>
            </x-ui.modal>
        @endif
    </div>
</div>
