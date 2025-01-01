<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
