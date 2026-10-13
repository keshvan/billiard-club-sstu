<div>
    <h1>Бильярдные столы</h1>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <div style="margin-bottom: 1rem;">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Поиск по названию">

        <select wire:model.live="hall">
            <option value="">Все залы</option>
            @foreach ($this->halls as $h) {
                <option value="{{ $h->id }}">{{ $h->name }}</option>
            }
            @endforeach
        </select>

        <button wire:click="create">Добавить стол</button>
    </div>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Зал</th>
                <th>Тип игры</th>
                <th>Активен</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tables as $table)
                <tr wire:key="table-{{ $table->id }}">
                    <td>{{ $table->id }}</td>
                    <td><a href="{{ route('billiard-tables.show', $table) }}" wire:navigate>{{ $table->name }}</a></</td>
                    <td><a href="{{ route('halls.show', $table->hall) }}" wire:navigate>{{ $table->hall->name }}</a></td>
                    <td>{{ $table->gameType->name }}</td>
                    <td>{{ $table->is_active ? 'Да' : 'Нет' }}</td>
                    <td>
                        <button wire:click="edit({{ $table->id }})">Изменить</button>
                        <button wire:click="confirmDelete({{ $table->id }})">Удалить</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Столов пока нет</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $tables->links() }}

    @if ($showModal)
        <div style="position: fixed; inset: 0; background: rgba(0,0,0,.5); display: flex; align-items: center; justify-content: center;">
            <div style="background: #fff; padding: 1.5rem; min-width: 400px;">
                <h2>{{ $form->billiardTable ? 'Редактирование стола' : 'Новый стол' }}</h2>

                <form wire:submit="save">
                    <div style="margin-bottom: 1rem;">
                        <label for="hall_id">Зал</label><br>
                        <select id="hall_id" wire:model="form.hall_id">
                            @foreach ($this->halls as $h)
                                <option value="{{ $h->id }}">{{ $h->name }}</option>
                            @endforeach
                        </select>
                        @error('form.hall_id') <div style="color: red;">{{ $message }}</div> @enderror
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="game_type_id">Тип игры</label><br>
                        <select id="game_type_id" wire:model="form.game_type_id">
                            @foreach ($this->gameTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('form.game_type_id') <div style="color: red;">{{ $message }}</div> @enderror
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="name">Название</label><br>
                        <input type="text" id="name" wire:model="form.name">
                        @error('form.name') <div style="color: red;">{{ $message }}</div> @enderror
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label>
                            <input type="checkbox" wire:model="form.is_active"> Активен
                        </label>
                        @error('form.is_active') <div style="color: red;">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit">Сохранить</button>
                    <button type="button" wire:click="closeModal">Отмена</button>
                </form>
            </div>
        </div>
    @endif

    @if ($this->deletingTable)
        <div style="position: fixed; inset: 0; background: rgba(0,0,0,.5); display: flex; align-items: center; justify-content: center;">
            <div style="background: #fff; padding: 1.5rem; min-width: 350px;">
                <p>
                    Удалить стол
                    <strong>#{{ $this->deletingTable->id }} «{{ $this->deletingTable->name }}»</strong>?
                </p>
                <button wire:click="delete">Да, удалить</button>
                <button wire:click="cancelDelete">Отмена</button>
            </div>
        </div>
    @endif
</div>
