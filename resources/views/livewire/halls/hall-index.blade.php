<div>
    <h1>Залы</h1>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <div style="margin-bottom: 1rem;">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Поиск по названию">
        <button wire:click="create">Добавить зал</button>
    </div>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Столов</th>
                <th>Тарифов</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($halls as $hall)
                <tr wire:key="hall-{{ $hall->id }}">
                    <td>{{ $hall->id }}</td>
                    <td><a href="{{ route('halls.show', $hall) }}" wire:navigate>{{ $hall->name }}</a></td>
                    <td>{{ \Illuminate\Support\Str::limit($hall->description, 60) }}</td>
                    <td>{{ $hall->billiard_tables_count }}</td>
                    <td>{{ $hall->tariffs_count }}</td>
                    <td>
                        <button wire:click="edit({{ $hall->id }})">Изменить</button>
                        <button wire:click="confirmDelete({{ $hall->id }})">Удалить</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Залов пока нет</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $halls->links() }}

    @if ($showModal)
        <div style="position: fixed; inset: 0; background: rgba(0,0,0,.5); display: flex; align-items: center; justify-content: center;">
            <div style="background: #fff; padding: 1.5rem; min-width: 400px;">
                <h2>{{ $form->hall ? 'Редактирование зала' : 'Новый зал' }}</h2>

                <form wire:submit="save">
                    <div style="margin-bottom: 1rem;">
                        <label for="name">Название</label><br>
                        <input type="text" id="name" wire:model="form.name">
                        @error('form.name') <div style="color: red;">{{ $message }}</div> @enderror
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="description">Описание</label><br>
                        <textarea id="description" rows="5" wire:model="form.description"></textarea>
                        @error('form.description') <div style="color: red;">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit">Сохранить</button>
                    <button type="button" wire:click="closeModal">Отмена</button>
                </form>
            </div>
        </div>
    @endif

    @if ($this->deletingHall)
        <div style="position: fixed; inset: 0; background: rgba(0,0,0,.5); display: flex; align-items: center; justify-content: center;">
            <div style="background: #fff; padding: 1.5rem; min-width: 350px;">
                <p>
                    Удалить зал
                    <strong>#{{ $this->deletingHall->id }} «{{ $this->deletingHall->name }}»</strong>?
                </p>
                <button wire:click="delete">Да, удалить</button>
                <button wire:click="cancelDelete">Отмена</button>
            </div>
        </div>
    @endif
</div>
