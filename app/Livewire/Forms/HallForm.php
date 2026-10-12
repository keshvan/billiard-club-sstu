<?php

namespace App\Livewire\Forms;

use App\Models\Hall;
use Illuminate\Validation\Rule;
use Livewire\Form;

class HallForm extends Form
{
    public ?Hall $hall = null;
    public string $name = '';
    public ?string $description = null;

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('halls', 'name')->ignore($this->hall?->id),
            ],
            'description' => ['nullable', 'string'],
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'name' => 'название',
            'description' => 'описание',
        ];
    }

    public function setHall(Hall $hall): void
    {
        $this->hall = $hall;
        $this->name = $hall->name;
        $this->description = $hall->description;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description ?: null,
        ];

        if ($this->hall) {
            $this->hall->update($data);
        } else {
            Hall::create($data);
        }

        $this->reset();
    }
}
