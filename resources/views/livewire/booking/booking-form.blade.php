<div style="max-width: 600px; margin: 20px auto; font-family: sans-serif;">
    <h1>Забронировать стол</h1>

    @if (session()->has('success'))
        <p style="color: green; padding: 10px; border: 1px solid green;">
            {{ session('success') }}
        </p>
    @endif

    <form wire:submit="save">
        <p>
            <label>Зал:</label><br>
            <select wire:model.live="hallId">
                <option value="">— выберите —</option>
                @foreach ($halls as $hall)
                    <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                @endforeach
            </select>
            @error('hallId') <br><small style="color:red">{{ $message }}</small> @enderror
        </p>

        @if ($hallId)
            <p>
                <label>Стол:</label><br>
                <select wire:model.live="tableId">
                    <option value="">— выберите —</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table->id }}">
                            {{ $table->name }} ({{ $table->gameType->name ?? '—' }})
                        </option>
                    @endforeach
                </select>
                @error('tableId') <br><small style="color:red">{{ $message }}</small> @enderror
            </p>
        @endif

        <p>
            <label>Дата:</label><br>
            <input type="date" wire:model.live="bookingDate" min="{{ now()->format('Y-m-d') }}">
            @error('bookingDate') <br><small style="color:red">{{ $message }}</small> @enderror
        </p>

        <p>
            <label>Время начала:</label><br>
            <input type="time" wire:model.live="startTime">
            @error('startTime') <br><small style="color:red">{{ $message }}</small> @enderror
        </p>

        <p>
            <label>Длительность (часы):</label><br>
            <input type="number" min="1" max="8" wire:model.live="durationHours">
            @error('durationHours') <br><small style="color:red">{{ $message }}</small> @enderror
        </p>

        @if ($tariffId && $totalPrice > 0)
            <p style="padding: 10px; background: #f0f0f0;">
                <strong>Итого: {{ number_format($totalPrice, 2) }} ₽</strong>
            </p>
        @endif

        <button type="submit">Забронировать</button>
    </form>
</div>