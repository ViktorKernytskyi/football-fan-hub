<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;

Route::get('/', function () {
    return view('welcome');
});

// Home page with upcoming matches - Головна сторінка з майбутніми матчами
Route::get('/', [MatchController::class, 'index'])->name('matches.home');
Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');// page that displays a list of matches
Route::get('/matches/{id}', [MatchController::class, 'show'])->name('matches.show');
Route::get('/show', [MatchController::class, 'showDefault'])->name('matches.default');


Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
Route::post('/tickets/{id}/purchase', [TicketController::class, 'purchase'])->name('tickets.purchase');


Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');


Route::prefix('auth')->middleware('guest')->group(function () {
    // Registration
    Route::get('register', [AuthController::class, 'registerForm'])->name('register.form');
    Route::post('register', [AuthController::class, 'register'])->name('register');

    // Login
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('login', [AuthController::class, 'loginValidate'])->name('login');

    // Entrance - Вихід
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    //  Password Reset - Step 1: Show Forgot Password Form
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    // Password Reset - Step 2: Send Reset Link
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

    // Password Reset - Step 3: Show Reset Form with Token
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    // Password Reset - Step 4: Update Password
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
    // Password update...
    Route::get('/password/reset/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::post('/password/reset/{token}', [AuthController::class, 'updatePassword'])->name('password.update');

});



