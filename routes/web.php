<?php

use App\Livewire\Halls\HallIndex;
use App\Livewire\Halls\HallShow;
use Illuminate\Support\Facades\Route;

Route::get('/halls', HallIndex::class)->name('halls.index');
Route::get('/halls/{hall}', HallShow::class)->name('halls.show');
