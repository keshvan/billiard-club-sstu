<?php

namespace App\Livewire\Tariffs;

use App\Models\Tariff;
use Livewire\Component;

class TariffShow extends Component
{
    public Tariff $tariff;

    public function mount(Tariff $tariff): void
    {
        $this->tariff = $tariff->load(['hall', 'gameType']);
    }

    public function render()
    {
        return view('livewire.tariffs.tariff-show');
    }
}
