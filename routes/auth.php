<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfirmationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'doLogin']);

    // Register
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'doRegister']);
});

Route::middleware('auth')->group(function () {
    Route::get('eventGate', [AuthController::class, 'showEventGate'])->name('eventGate');
    Route::get('/events/{eventId}/confirmation', [ConfirmationController::class, 'showConfirmation'])->name('events.confirmation');
    Route::post('/events/{eventId}/confirmation/confirm', [ConfirmationController::class, 'doConfirm'])->name('events.confirmation.confirm');

    // Logout
    Route::get('logout', [AuthController::class, 'doLogout'])->name('logout');
});
