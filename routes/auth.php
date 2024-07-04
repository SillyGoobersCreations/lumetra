<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('login', [AuthController::class, 'doLogin']);

    // Register
    Route::get('register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('register', [AuthController::class, 'doRegister']);
});

Route::middleware('auth')->group(function () {
    // Logout
    Route::get('logout', [AuthController::class, 'doLogout'])->name('auth.logout');
});
