<?php

use App\Http\Controllers\Admin\IndexController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/events/{eventId}/admin', [IndexController::class, 'showIndex'])->name('events.admin');
});
