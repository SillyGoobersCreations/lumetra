<?php

use App\Http\Controllers\Admin\AttendeeController;
use App\Http\Controllers\Admin\EventSettingsController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Middleware\AdminAccess;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AdminAccess::class])->group(function () {
    Route::get('/events/{eventId}/admin', [IndexController::class, 'showIndex'])->name('events.admin');
    Route::get('/events/{eventId}/admin/attendees', [AttendeeController::class, 'showOverview'])->name('events.admin.attendees');
    Route::get('/events/{eventId}/admin/attendees/{attendeeId}/confirmation/confirm', [AttendeeController::class, 'doConfirmConfirmation'])->name('events.admin.attendees.confirmation.confirm');
    Route::get('/events/{eventId}/admin/attendees/{attendeeId}/confirmation/revoke', [AttendeeController::class, 'doRevokeConfirmation'])->name('events.admin.attendees.confirmation.revoke');

    Route::get('/events/{eventId}/admin/eventSettings', [EventSettingsController::class, 'showIndex'])->name('events.admin.eventSettings');
    Route::post('/events/{eventId}/admin/eventSettings', [EventSettingsController::class, 'doSave'])->name('events.admin.eventSettings.doSave');
    Route::post('/events/{eventId}/admin/eventSettings/logo', [EventSettingsController::class, 'doSaveLogo'])->name('events.admin.eventSettings.doSaveLogo');
    Route::get('/events/{eventId}/admin/eventSettings/clearLogo', [EventSettingsController::class, 'doClearLogo'])->name('events.admin.eventSettings.doClearLogo');

    Route::get('/events/{eventId}/admin/rooms', [RoomController::class, 'showIndex'])->name('events.admin.rooms');
    Route::post('/events/{eventId}/admin/rooms/create', [RoomController::class, 'doCreate'])->name('events.admin.rooms.create');
    Route::post('/events/{eventId}/admin/rooms/update/{roomId}', [RoomController::class, 'doUpdate'])->name('events.admin.rooms.update');
    Route::get('/events/{eventId}/admin/rooms/delete/{roomId}', [RoomController::class, 'doDelete'])->name('events.admin.rooms.delete');
});
