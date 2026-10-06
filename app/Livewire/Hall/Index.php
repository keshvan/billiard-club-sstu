<?php

namespace App\Livewire\Hall;

use App\Models\Hall;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.hall.index', [
            'halls' => Hall::all(),
        ]);
    }
}
