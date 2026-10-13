<?php

namespace App\Livewire\Halls;

use App\Livewire\Forms\HallForm;
use App\Models\Hall;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class HallIndex extends Component
{
    use WithPagination;

    public HallForm $form;

    public string $search = '';

    public bool $showModal = false;

    public ?int $deletingId = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->form->reset();
        $this->form->resetValidation();
        $this->showModal = true;
    }

    public function edit(Hall $hall): void
    {
        $this->form->resetValidation();
        $this->form->setHall($hall);
        $this->showModal = true;
    }

    public function save(): void
    {
        $isNew = ! $this->form->hall;

        $this->form->save();

        $this->showModal = false;
        session()->flash('success', $isNew ? 'Зал создан' : 'Зал обновлён');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->form->reset();
        $this->form->resetValidation();
    }

    #[Computed]
    public function deletingHall(): ?Hall
    {
        return $this->deletingId ? Hall::find($this->deletingId) : null;
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
        $hall = $this->deletingHall;

        if (! $hall) {
            $this->deletingId = null;
            return;
        }

        if ($hall->billiardTables()->withTrashed()->exists() || $hall->tariffs()->exists()) {
            session()->flash('error', "Нельзя удалить зал «{$hall->name}»: к нему привязаны столы или тарифы");
        } else {
            $hall->delete();
            session()->flash('success', "Зал «{$hall->name}» удалён");
        }

        $this->deletingId = null;
        unset($this->deletingHall);
    }

    public function render()
    {
        $halls = Hall::withCount(['billiardTables', 'tariffs'])
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.halls.hall-index', compact('halls'));
    }
}
