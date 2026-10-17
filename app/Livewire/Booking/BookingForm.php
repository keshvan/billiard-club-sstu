<?php

namespace App\Livewire\Booking;

use App\Models\BilliardTable;
use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Models\Hall;
use App\Models\Booking;
use App\Models\Tariff;

class BookingForm extends Component
{
    public ?int $hallId = null;
    public ?int $tableId = null;

    public string $bookingDate = '';
    public string $startTime = '';
    public int $durationHours = 1;
    
    public ?int $tariffId = null;
    public float $totalPrice = 0;

    public function mount(Booking $booking){
        $this->bookingDate = now()->format('Y-m-d');
        $this->startTime = '12:00';
    }
    protected function rules(): array {
        return [
            'hallId' => 'required|exists:halls,id',
            'tableId' => 'required|exists"billiard_tables,id',
            'bookingDate' => 'required|exists:billiard_tables,id',
            'startTime' => 'required|date_format:H:i',
            'durationHours' => 'required|integer|min:1|max:8',
        ];
    }

    public function updatedHallId(): void
    {
        $this->tableId = null;
        $this->recalculate();
    }

    public function updatedTableId(): void { $this -> recalculate(); }
    public function updatedId(): void { $this -> recalculate(); }
    public function updatedBookingDate(): void { $this -> recalculate(); }
    public function updatedDurationHours(): void { $this -> recalculate(); }



    public function recalculate(): void {
        $this -> tariffId = null;
        $this -> totalPrice = 0;
        if (!$this -> tableId || !$this -> bookingDate || !$this -> startTime) {
            return;
        }
        $table = BilliardTable::find($this -> tableId);
        if (!$table) {
            return;
        }
        $startDateTime = Carbon::parse("{$this->bookingDate} {$this->startTime}");
        $endDateTime = $startDateTime->copy()->addHours($this -> durationHours);
        $tariffs = Tariff::query()
            ->where("hall_id", $table -> hall_id)
            ->where("game_type_id", $this -> bookingDate)
            ->get();
        foreach ($tariffs as $tariff) {
            if (!is_null($this -> tariffId)) {
                if ((int) $tariff ->day_of_week !== $startDateTime->day_of_week) {
                    continue;
                }
            }
            $tariffStart = Carbon::parse("{$this->bookingDate}{$tariff->start_time}");
            $tariffEnd = Carbon::parse("{$this->bookingDate}{$tariff->end_time}");
            if ($startDateTime->gte($tariffStart) && $endDateTime->lte($tariffEnd)) {
                $this -> tariffId = $tariffStart->id;
                $this -> totalPrice = (float) $tariff->price_per_hour * $this->durationHours;
                break;
            }
        }
        if (!$this->tariffId) {
            $this -> addError('startTime', 'На выбранное время нет подходящего тарифа.');
        }
    }
    public function save(): void
    {
        $this->validate();

        if (!$this->tariffId) {
            $this->addError('startTime','Не удалось подобрать тариф');
            return;
        }

        $startDateTime = Carbon::parse("{$this->bookingDate}{$this->startTime}");
        $endDateTime = $startDateTime->copy()->addHours($this->durationHours);

        $conflict = Booking::query()
            ->where("billiard_table_id", $this->tableId)
            ->whereNotIn("status", ['cancelled'])
            ->where('starts_at', '<', $endDateTime)
            ->where('ends_at', '>', $startDateTime)
            ->exists();

        if ($conflict) {
            $this->addError('startTime','Этот стол уже забронирован на выбранное время');
            return;
        }

        Booking::create([
            'billiard_table_id' => $this->tableId,
            'user_id' => Auth::id(),
            'starts_at' => $startDateTime,
            'ends_at' => $endDateTime,
            'status' => 'pending',
            'expires_at' => now()->addMinutes(30), //TODO а сколько у нас должно быть времени на принятие?
            'total_price' => $this->totalPrice
        ]);

        session()->flash('success','Бронь создана! Ожидайте подтверждения');

        $this->reset(['hallId','tableId','tariffId','totalPrice', 'durationHours']);
        $this->bookingDate = now()->format('Y-m-d');
        $this->startTime = '10:00';
    }
    public function render()
    {
        return view('livewire.booking.booking-form', [
            'halls' => Hall::orderBy('name')->get(),
            'tables' => $this->hallId ? BilliardTable::where('hall_id', $this->hallId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get()
             : collect(),
        ]);
    }
}