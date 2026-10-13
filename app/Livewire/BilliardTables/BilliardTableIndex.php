<?php

namespace App\Livewire\BilliardTables;

use App\Livewire\Forms\BilliardTableForm;
use App\Models\BilliardTable;
use App\Models\GameType;
use App\Models\Hall;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BilliardTableIndex extends Component
{
    use WithPagination;

    public BilliardTableForm $form;

    public string $search = '';

    #[Url(except:'')]
    public string $hall = '';

    public bool $showModal = false;

    public ?int $deletingId = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingHall(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function halls(): Collection
    {
        return Hall::orderBy('id')->get(['id', 'name']);
    }

    #[Computed]
    public function gameTypes(): Collection
    {
        return GameType::orderBy('name')->get(['id', 'name']);
    }

    #[Computed]
    public function deletingTable(): ?BilliardTable
    {
        return $this->deletingId ? BilliardTable::find($this->deletingId) : null;
    }

    public function create(): void
    {
        $this->form->reset();
        $this->form->resetValidation();
        $this->form->hall_id = $this->hall !== '' ? (int) $this->hall : null;
        $this->showModal = true;
    }

    public function edit(BilliardTable $billiardTable): void
    {
        $this->form->resetValidation();
        $this->form->setBilliardTable($billiardTable);
        $this->showModal = true;
    }

    public function save(): void
    {
        $isNew = ! $this->form->billiardTable;

        $this->form->save();

        $this->showModal = false;
        session()->flash('success', $isNew ? 'Стол создан' : 'Стол обновлён');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->form->reset();
        $this->form->resetValidation();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
    }

    public function cancelDelete(): void
    {
        $this->deletingId = null;
    }

    public function delete(): void
    {
        $table = $this->deletingTable;

        if ($table) {
            $table->delete();
            session()->flash('success', "Стол «{$table->name}» удалён");
        }

        $this->deletingId = null;
        unset($this->deletingTable);
    }

    public function render()
    {
        $tables = BilliardTable::with(['hall:id,name', 'gameType:id,name'])
            ->when($this->search !== '', fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->hall !== '', fn ($q) => $q->where('hall_id', $this->hall))
            ->orderBy('hall_id')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.billiard-tables.billiard-table-index', compact('tables'));
    }
}
