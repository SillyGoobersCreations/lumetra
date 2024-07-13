<?php

use App\Http\Controllers\AuthController;
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
    // Logout
    Route::get('logout', [AuthController::class, 'doLogout'])->name('logout');
});
