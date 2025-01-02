<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
