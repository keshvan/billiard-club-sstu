<?php

use App\Livewire\BilliardTables\BilliardTableIndex;
use App\Livewire\BilliardTables\BilliardTableShow;
use App\Livewire\Booking\BookingForm;
use App\Livewire\Halls\HallIndex;
use App\Livewire\Halls\HallShow;
use App\Livewire\Tariffs\TariffIndex;
use App\Livewire\Tariffs\TariffShow;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('book', BookingForm::class)
    ->middleware('auth')
    ->name('booking.form');

Route::get('/halls', HallIndex::class)->name('halls.index');
Route::get('/halls/{hall}', HallShow::class)->name('halls.show');

Route::get('/tables', BilliardTableIndex::class)->name('billiard-tables.index');
Route::get('/tables/{billiardTable}', BilliardTableShow::class)->name('billiard-tables.show');

Route::get('/tariffs', TariffIndex::class)->name('tariffs.index');
Route::get('/tariffs/{tariff}', TariffShow::class)->name('tariffs.show');

require __DIR__.'/auth.php';
