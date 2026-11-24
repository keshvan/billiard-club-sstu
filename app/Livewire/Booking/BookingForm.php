<?php

namespace App\Livewire\Booking;

use App\Models\BilliardTable;
use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Models\Hall;
use App\Models\Booking;
use App\Models\Tariff;
use App\Enums\BookingStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BookingForm extends Component
{
    public ?int $hallId = null;
    public ?int $tableId = null;

    public string $bookingDate = '';
    public string $startTime = '';
    public int $durationHours = 1;

    public ?int $tariffId = null;
    public float $totalPrice = 0;

    public function mount(): void
    {
        $this->bookingDate = now()->format('Y-m-d');
        $this->startTime = '12:00';
    }

    protected function rules(): array
    {
        return [
            'hallId' => 'required|exists:halls,id',
            'tableId' => [
                'required',
                Rule::exists('billiard_tables', 'id')->where(fn ($query) => $query
                    ->where('hall_id', $this->hallId)
                    ->where('is_active', true)),
            ],
            'bookingDate' => 'required|date|after_or_equal:today',
            'startTime' => 'required|date_format:H:i',
            'durationHours' => 'required|integer|min:1|max:8',
        ];
    }

    public function updatedHallId(): void
    {
        $this->tableId = null;
        $this->recalculate();
    }

    public function updatedTableId(): void { $this->recalculate(); }
    public function updatedBookingDate(): void { $this->recalculate(); }
    public function updatedStartTime(): void { $this->recalculate(); }
    public function updatedDurationHours(): void { $this->recalculate(); }

    public function recalculate(): void
    {
        $this->resetValidation('startTime');
        $this->tariffId = null;
        $this->totalPrice = 0;

        if (!$this->tableId || !$this->bookingDate || !$this->startTime
            || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->bookingDate)
            || !preg_match('/^\d{2}:\d{2}$/', $this->startTime)
            || $this->durationHours < 1 || $this->durationHours > 8) {
            return;
        }

        try {
            $startDateTime = Carbon::createFromFormat('!Y-m-d H:i', "{$this->bookingDate} {$this->startTime}");
        } catch (\Throwable) {
            return;
        }

        if (!$startDateTime) {
            return;
        }

        $table = BilliardTable::query()
            ->whereKey($this->tableId)
            ->where('hall_id', $this->hallId)
            ->where('is_active', true)
            ->first();
        if (!$table) {
            return;
        }

        $endDateTime = $startDateTime->copy()->addHours($this->durationHours);
        $tariffs = Tariff::query()
            ->where('hall_id', $table->hall_id)
            ->where('game_type_id', $table->game_type_id)
            ->get();

        foreach ($tariffs as $tariff) {
            // For a booking after midnight, an overnight tariff may have started the previous day.
            foreach ([$startDateTime->copy(), $startDateTime->copy()->subDay()] as $dateCandidate) {
                $candidateStart = $dateCandidate->copy()->setTimeFromTimeString($tariff->start_time);
                $candidateEnd = $dateCandidate->copy()->setTimeFromTimeString($tariff->end_time);
                if ($candidateEnd->lessThanOrEqualTo($candidateStart)) {
                    $candidateEnd->addDay();
                }

                $tariffDay = $tariff->day_of_week?->value;
                if ($tariffDay !== null && $tariffDay !== $dateCandidate->dayOfWeekIso) {
                    continue;
                }

                if ($startDateTime->greaterThanOrEqualTo($candidateStart)
                    && $endDateTime->lessThanOrEqualTo($candidateEnd)) {
                    $this->tariffId = $tariff->id;
                    $this->totalPrice = (float) $tariff->price_per_hour * $this->durationHours;
                    return;
                }
            }
        }

        $this->addError('startTime', 'На выбранное время нет подходящего тарифа.');
    }

    public function save(): void
    {
        $this->validate();
        $this->recalculate();

        if (!$this->tariffId) {
            $this->addError('startTime', 'Не удалось подобрать тариф.');
            return;
        }

        $startDateTime = Carbon::createFromFormat('!Y-m-d H:i', "{$this->bookingDate} {$this->startTime}");
        $endDateTime = $startDateTime->copy()->addHours($this->durationHours);

        $blockingStatuses = array_map(
            fn (BookingStatus $status) => $status->value,
            BookingStatus::blocking(),
        );

        $conflict = Booking::query()
            ->where('billiard_table_id', $this->tableId)
            ->whereIn('status', $blockingStatuses)
            ->where('starts_at', '<', $endDateTime)
            ->where('ends_at', '>', $startDateTime)
            ->exists();

        if ($conflict) {
            $this->addError('startTime', 'Этот стол уже забронирован на выбранное время.');
            return;
        }

        Booking::create([
            'billiard_table_id' => $this->tableId,
            'user_id' => Auth::id(),
            'starts_at' => $startDateTime,
            'ends_at' => $endDateTime,
            'status' => 'pending',
            'expires_at' => now()->addMinutes(30), //TODO а сколько у нас должно быть времени на принятие?
            'total_price' => $this->totalPrice,
        ]);

        session()->flash('success', 'Бронь создана! Ожидайте подтверждения.');

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
