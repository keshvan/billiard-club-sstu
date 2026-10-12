<?php

namespace App\Livewire\Halls;

use App\Models\Hall;
use Livewire\Component;

class HallShow extends Component
{
    public Hall $hall;

    public function mount(Hall $hall): void
    {
        $this->hall = $hall->load(['billiardTables', 'tariffs']);
    }

    public function render()
    {
        return view('livewire.halls.hall-show');
    }
}
