<div>
    <h1>Тарифы</h1>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <div style="margin-bottom: 1rem;">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Поиск по названию">

        <select wire:model.live="hall">
            <option value="">Все залы</option>
            @foreach ($this->halls as $h)
                <option value="{{ $h->id }}">{{ $h->name }}</option>
            @endforeach
        </select>

        <button wire:click="create">Добавить тариф</button>
    </div>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Зал</th>
                <th>Тип игры</th>
                <th>День</th>
                <th>Время</th>
                <th>Цена/час</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tariffs as $tariff)
                <tr wire:key="tariff-{{ $tariff->id }}">
                    <td>{{ $tariff->id }}</td>
                    <td><a href="{{ route('tariffs.show', $tariff) }}" wire:navigate>{{ $tariff->name }}</a></td>
                    <td><a href="{{ route('halls.show', $tariff->hall) }}" wire:navigate>{{ $tariff->hall->name }}</a></td>
                    <td>{{ $tariff->gameType->name }}</td>
                    <td>{{ \App\Models\Tariff::DAYS[$tariff->day_of_week] ?? 'Каждый день' }}</td>
                    <td>{{ substr($tariff->start_time, 0, 5) }}–{{ substr($tariff->end_time, 0, 5) }}</td>
                    <td>{{ number_format($tariff->price_per_hour, 2, ',', ' ') }}</td>
                    <td>
                        <button wire:click="edit({{ $tariff->id }})">Изменить</button>
                        <button wire:click="confirmDelete({{ $tariff->id }})">Удалить</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">Тарифов пока нет</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $tariffs->links() }}

    @if ($showModal)
        <div style="position: fixed; inset: 0; background: rgba(0,0,0,.5); display: flex; align-items: center; justify-content: center;">
            <div style="background: #fff; padding: 1.5rem; min-width: 400px;">
                <h2>{{ $form->tariff ? 'Редактирование тарифа' : 'Новый тариф' }}</h2>

                <form wire:submit="save">
                    <div style="margin-bottom: 1rem;">
                        <label for="hall_id">Зал</label><br>
                        <select id="hall_id" wire:model="form.hall_id">
                            <option value="">Выберите зал</option>
                            @foreach ($this->halls as $h)
                                <option value="{{ $h->id }}">{{ $h->name }}</option>
                            @endforeach
                        </select>
                        @error('form.hall_id') <div style="color: red;">{{ $message }}</div> @enderror
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="game_type_id">Тип игры</label><br>
                        <select id="game_type_id" wire:model="form.game_type_id">
                            <option value="">Выберите тип игры</option>
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
                        <label for="day_of_week">День недели</label><br>
                        <select id="day_of_week" wire:model="form.day_of_week">
                            <option value="">Каждый день</option>
                            @foreach (\App\Models\Tariff::DAYS as $num => $label)
                                <option value="{{ $num }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('form.day_of_week') <div style="color: red;">{{ $message }}</div> @enderror
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="start_time">Начало</label>
                        <input type="time" id="start_time" wire:model="form.start_time">
                        <label for="end_time">Конец</label>
                        <input type="time" id="end_time" wire:model="form.end_time">
                        @error('form.start_time') <div style="color: red;">{{ $message }}</div> @enderror
                        @error('form.end_time') <div style="color: red;">{{ $message }}</div> @enderror
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="price_per_hour">Цена за час</label><br>
                        <input type="number" id="price_per_hour" step="0.01" min="0" wire:model="form.price_per_hour">
                        @error('form.price_per_hour') <div style="color: red;">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit">Сохранить</button>
                    <button type="button" wire:click="closeModal">Отмена</button>
                </form>
            </div>
        </div>
    @endif

    @if ($this->deletingTariff)
        <div style="position: fixed; inset: 0; background: rgba(0,0,0,.5); display: flex; align-items: center; justify-content: center;">
            <div style="background: #fff; padding: 1.5rem; min-width: 350px;">
                <p>
                    Удалить тариф
                    <strong>#{{ $this->deletingTariff->id }} «{{ $this->deletingTariff->name }}»</strong>?
                </p>
                <button wire:click="delete">Да, удалить</button>
                <button wire:click="cancelDelete">Отмена</button>
            </div>
        </div>
    @endif
</div>
