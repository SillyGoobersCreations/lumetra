<?php

use App\Http\Controllers\Admin\AttendeeController;
use App\Http\Controllers\Admin\IndexController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/events/{eventId}/admin', [IndexController::class, 'showIndex'])->name('events.admin');
    Route::get('/events/{eventId}/admin/attendees', [AttendeeController::class, 'showOverview'])->name('events.admin.attendees');
    Route::get('/events/{eventId}/admin/attendees/{attendeeId}/confirmation/confirm', [AttendeeController::class, 'doConfirmConfirmation'])->name('events.admin.attendees.confirmation.confirm');
    Route::get('/events/{eventId}/admin/attendees/{attendeeId}/confirmation/revoke', [AttendeeController::class, 'doRevokeConfirmation'])->name('events.admin.attendees.confirmation.revoke');
});
