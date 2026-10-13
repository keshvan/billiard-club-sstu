<?php

namespace App\Livewire\Forms;

use App\Models\BilliardTable;
use Illuminate\Validation\Rule;
use Livewire\Form;

class BilliardTableForm extends Form
{
    public ?BilliardTable $billiardTable = null;

    public int|string|null $hall_id = null;

    public int|string|null $game_type_id = null;

    public string $name = '';

    public bool $is_active = true;

    protected function rules(): array
    {
        return [
            'hall_id' => ['required', 'integer', 'exists:halls,id'],
            'game_type_id' => ['required', 'integer', 'exists:game_types,id'],
            'name' => [
                'required',
                'string',
                'max:255',

                Rule::unique('billiard_tables', 'name')
                    ->where('hall_id', $this->hall_id)
                    ->ignore($this->billiardTable?->id),
            ],
            'is_active' => ['boolean'],
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'hall_id' => 'зал',
            'game_type_id' => 'тип игры',
            'name' => 'название',
            'is_active' => 'активность',
        ];
    }

    public function setBilliardTable(BilliardTable $billiardTable): void
    {
        $this->billiardTable = $billiardTable;
        $this->hall_id = $billiardTable->hall_id;
        $this->game_type_id = $billiardTable->game_type_id;
        $this->name = $billiardTable->name;
        $this->is_active = $billiardTable->is_active;
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->billiardTable) {
            $this->billiardTable->update($data);
        } else {
            BilliardTable::create($data);
        }

        $this->reset();
    }
}
