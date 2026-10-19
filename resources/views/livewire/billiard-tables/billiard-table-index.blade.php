<div class="py-6">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mb-4 text-2xl font-bold">Бильярдные столы</h1>

        @if (session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif

        <div class="mb-4 flex flex-wrap gap-2">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Поиск по названию"
                   class="rounded border border-gray-400 px-2 py-1">

            <select wire:model.live="hall" class="rounded border border-gray-400 px-2 py-1">
                <option value="">Все залы</option>
                @foreach ($this->halls as $h)
                    <option value="{{ $h->id }}">{{ $h->name }}</option>
                @endforeach
            </select>

            <button wire:click="create" class="rounded border border-gray-400 bg-gray-100 px-3 py-1 hover:bg-gray-200">
                Добавить стол
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-400">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="border border-gray-400 p-1.5">ID</th>
                        <th class="border border-gray-400 p-1.5">Название</th>
                        <th class="border border-gray-400 p-1.5">Зал</th>
                        <th class="border border-gray-400 p-1.5">Тип игры</th>
                        <th class="border border-gray-400 p-1.5">Активен</th>
                        <th class="border border-gray-400 p-1.5">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tables as $table)
                        <tr wire:key="table-{{ $table->id }}">
                            <td class="border border-gray-400 p-1.5">{{ $table->id }}</td>
                            <td class="border border-gray-400 p-1.5">
                                <a href="{{ route('billiard-tables.show', $table) }}" wire:navigate
                                   class="text-blue-600 underline hover:text-blue-800">{{ $table->name }}</a>
                            </td>
                            <td class="border border-gray-400 p-1.5">
                                <a href="{{ route('halls.show', $table->hall) }}" wire:navigate
                                   class="text-blue-600 underline hover:text-blue-800">{{ $table->hall->name }}</a>
                            </td>
                            <td class="border border-gray-400 p-1.5">{{ $table->gameType->name }}</td>
                            <td class="border border-gray-400 p-1.5">{{ $table->is_active ? 'Да' : 'Нет' }}</td>
                            <td class="space-x-1 border border-gray-400 p-1.5">
                                <button wire:click="edit({{ $table->id }})"
                                        class="rounded border border-gray-400 bg-gray-100 px-2 py-0.5 hover:bg-gray-200">Изменить</button>
                                <button wire:click="confirmDelete({{ $table->id }})"
                                        class="rounded border border-gray-400 bg-gray-100 px-2 py-0.5 hover:bg-gray-200">Удалить</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="border border-gray-400 p-1.5">Столов пока нет</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $tables->links() }}</div>

        @if ($showModal)
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

        @if ($this->deletingTable)
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
</div>
