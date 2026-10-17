<?php
use App\Livewire\Booking\BookingForm;
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

require __DIR__.'/auth.php';
