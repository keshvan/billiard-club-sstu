<?php

use App\Livewire\BilliardTables\BilliardTableIndex;
use App\Livewire\BilliardTables\BilliardTableShow;
use App\Livewire\Halls\HallIndex;
use App\Livewire\Halls\HallShow;
use App\Livewire\Tariffs\TariffIndex;
use App\Livewire\Tariffs\TariffShow;
use Illuminate\Support\Facades\Route;

Route::get('/halls', HallIndex::class)->name('halls.index');
Route::get('/halls/{hall}', HallShow::class)->name('halls.show');

Route::get('/billiard-tables', BilliardTableIndex::class)->name('billiard-tables.index');
Route::get('/billiard-tables/{billiardTable}', BilliardTableShow::class)->name('billiard-tables.show');

Route::get('/tariffs', TariffIndex::class)->name('tariffs.index');
Route::get('/tariffs/{tariff}', TariffShow::class)->name('tariffs.show');
