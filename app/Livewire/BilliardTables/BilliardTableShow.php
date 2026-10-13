<?php

namespace App\Livewire\BilliardTables;

use App\Models\BilliardTable;
use Livewire\Component;

class BilliardTableShow extends Component
{
    public BilliardTable $billiardTable;

    public function mount(BilliardTable $billiardTable)
    {
        $this->billiardTable = $billiardTable->load(['hall', 'gameType']);
    }

    public function render()
    {
        return view('livewire.billiard-tables.billiard-table-show');
    }
}
