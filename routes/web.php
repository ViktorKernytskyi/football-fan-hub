<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
