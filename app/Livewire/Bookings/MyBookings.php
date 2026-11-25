<?php

namespace App\Livewire\Bookings;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class MyBookings extends Component
{
    use WithPagination;

    public function render()
    {
        $bookings = Booking::query()
            ->where('user_id', auth()->id())
            ->with(['billiardTable.hall', 'billiardTable.gameType'])
            ->orderByDesc('starts_at')
            ->paginate(10);

        return view('livewire.bookings.my-bookings', compact('bookings'));
    }
}
