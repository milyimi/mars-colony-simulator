<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ColonyGame;

Route::get('/', ColonyGame::class)->name('home');
Route::get('/rules', function () {
    return view('rules');
})->name('rules');
