<?php

namespace App\Livewire\Bookings;

use App\Enums\BookingStatus;
use App\Livewire\Concerns\AuthorizesAdmin;
use App\Models\Booking;
use App\Models\BilliardTable;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class BookingIndex extends Component
{
    use WithPagination;
    use AuthorizesAdmin;

    public string $status = '';

    public function approve(Booking $booking): void
    {
        $this->authorizeAdmin();

        $result = DB::transaction(function () use ($booking): string {
            BilliardTable::query()
                ->whereKey($booking->billiard_table_id)
                ->lockForUpdate()
                ->firstOrFail();

            $booking = Booking::query()
                ->whereKey($booking->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if ($booking->status !== BookingStatus::Pending) {
                return 'not_pending';
            }

            $blockingStatuses = array_map(
                fn (BookingStatus $status) => $status->value,
                BookingStatus::blocking(),
            );

            $hasConflict = Booking::query()
                ->where('billiard_table_id', $booking->billiard_table_id)
                ->where('id', '!=', $booking->id)
                ->whereIn('status', $blockingStatuses)
                ->where('starts_at', '<', $booking->ends_at)
                ->where('ends_at', '>', $booking->starts_at)
                ->exists();

            if ($hasConflict) {
                return 'conflict';
            }

            $booking->status = BookingStatus::Confirmed;
            $booking->confirmed_at = now();
            $booking->expires_at = null;
            $booking->save();

            return 'approved';
        });

        match ($result) {
            'approved' => session()->flash('success', 'Бронирование подтверждено.'),
            'conflict' => session()->flash('error', 'Нельзя подтвердить бронь: это время уже занято.'),
            default => session()->flash('error', 'Можно подтвердить только ожидающую бронь.'),
        };
    }

    public function reject(Booking $booking): void
    {
        $this->authorizeAdmin();

        $rejected = DB::transaction(function () use ($booking): bool {
            $booking = Booking::query()
                ->whereKey($booking->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if ($booking->status !== BookingStatus::Pending) {
                return false;
            }

            $booking->status = BookingStatus::Rejected;
            $booking->expires_at = null;
            $booking->save();

            return true;
        });

        if ($rejected) {
            session()->flash('success', 'Бронирование отклонено.');
            return;
        }

        session()->flash('error', 'Можно отклонить только ожидающую бронь.');
    }

    public function render()
    {
        $bookings = Booking::query()
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->orderBy('created_at')
            ->paginate(10);

        return view('livewire.bookings.booking-index', compact('bookings'));
    }
}
