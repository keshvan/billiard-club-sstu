<?php

namespace App\Livewire\Tariffs;

use App\Livewire\Forms\TariffForm;
use App\Models\GameType;
use App\Models\Hall;
use App\Models\Tariff;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TariffIndex extends Component
{
    use WithPagination;

    public TariffForm $form;

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
        return Hall::orderBy('name')->get(['id', 'name']);
    }

    #[Computed]
    public function gameTypes(): Collection
    {
        return GameType::orderBy('name')->get(['id', 'name']);
    }

    #[Computed]
    public function deletingTariff(): ?Tariff
    {
        return $this->deletingId ? Tariff::find($this->deletingId) : null;
    }

    public function create(): void
    {
        $this->form->reset();
        $this->form->resetValidation();
        $this->form->hall_id = $this->hall !== '' ? (int) $this->hall : null;
        $this->showModal = true;
    }

    public function edit(Tariff $tariff): void
    {
        $this->form->resetValidation();
        $this->form->setTariff($tariff);
        $this->showModal = true;
    }

    public function save(): void
    {
        $isNew = ! $this->form->tariff;

        $this->form->save();

        $this->showModal = false;
        session()->flash('success', $isNew ? 'Тариф создан' : 'Тариф обновлён');
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
        $tariff = $this->deletingTariff;

        if ($tariff) {
            $tariff->delete();
            session()->flash('success', "Тариф «{$tariff->name}» удалён");
        }

        $this->deletingId = null;
        unset($this->deletingTariff);
    }

    public function render()
    {
        $tariffs = Tariff::with(['hall:id,name', 'gameType:id,name'])
            ->when($this->search !== '', fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->hall !== '', fn ($q) => $q->where('hall_id', $this->hall))
            ->orderBy('hall_id')
            ->orderBy('game_type_id')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->paginate(10);

        return view('livewire.tariffs.tariff-index', compact('tariffs'));
    }
}
