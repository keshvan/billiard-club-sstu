<?php

use App\Livewire\Hall\Index;
use Illuminate\Support\Facades\Route;

Route::get('/halls', Index::class)->name('halls.index');
