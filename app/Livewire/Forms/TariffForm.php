<?php

namespace App\Livewire\Forms;

use App\Models\Tariff;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TariffForm extends Form
{
    public ?Tariff $tariff = null;

    public int|string|null $hall_id = null;

    public int|string|null $game_type_id = null;

    public string $name = '';

    public int|string|null $day_of_week = null;

    public string $start_time = '';

    public string $end_time = '';

    public string $price_per_hour = '';

    protected function rules(): array
    {
        return [
            'hall_id' => ['required', 'integer', 'exists:halls,id'],
            'game_type_id' => ['required', 'integer', 'exists:game_types,id'],
            'name' => ['required', 'string', 'max:255'],
            'day_of_week' => ['nullable', 'integer', Rule::in(array_keys(Tariff::DAYS))],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'different:start_time'],
            'price_per_hour' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'hall_id' => 'зал',
            'game_type_id' => 'тип игры',
            'name' => 'название',
            'day_of_week' => 'день недели',
            'start_time' => 'начало',
            'end_time' => 'конец',
            'price_per_hour' => 'цена за час',
        ];
    }

    public function setTariff(Tariff $tariff): void
    {
        $this->tariff = $tariff;
        $this->hall_id = $tariff->hall_id;
        $this->game_type_id = $tariff->game_type_id;
        $this->name = $tariff->name;
        $this->start_time = substr($tariff->start_time, 0, 5);  // HH:MM:SS -> HH:MM
        $this->end_time = substr($tariff->end_time, 0, 5);
        $this->price_per_hour = (string) $tariff->price_per_hour;
    }

    public function save(): void
    {
        $data = $this->validate();
        $data['day_of_week'] = $data['day_of_week'] ?: null; // '' -> null

        if ($this->tariff) {
            $this->tariff->update($data);
        } else {
            Tariff::create($data);
        }

        $this->reset();
    }
}
