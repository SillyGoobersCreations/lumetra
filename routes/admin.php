<?php

use App\Http\Controllers\Admin\AttendeeController;
use App\Http\Controllers\Admin\EventSettingsController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Middleware\AdminAccess;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AdminAccess::class])->group(function () {
    Route::get('/events/{eventId}/admin', [IndexController::class, 'showIndex'])->name('events.admin');

    Route::get('/events/{eventId}/admin/notes', [NoteController::class, 'showOverview'])->name('events.admin.notes');
    Route::post('/events/{eventId}/admin/notes/create', [NoteController::class, 'doCreate'])->name('events.admin.notes.create');
    Route::get('/events/{eventId}/admin/notes/{noteId}/delete', [NoteController::class, 'doDelete'])->name('events.admin.notes.delete');
    Route::get('/events/{eventId}/admin/notes/{noteId}/setSticky/{sticky}', [NoteController::class, 'doSetSticky'])->name('events.admin.notes.setSticky');

    Route::get('/events/{eventId}/admin/attendees', [AttendeeController::class, 'showOverview'])->name('events.admin.attendees');
    Route::get('/events/{eventId}/admin/attendees/{attendeeId}/confirmation/confirm', [AttendeeController::class, 'doConfirmConfirmation'])->name('events.admin.attendees.confirmation.confirm');
    Route::get('/events/{eventId}/admin/attendees/{attendeeId}/confirmation/revoke', [AttendeeController::class, 'doRevokeConfirmation'])->name('events.admin.attendees.confirmation.revoke');
    Route::get('/events/{eventId}/admin/attendees/{attendeeId}/organizer/make', [AttendeeController::class, 'doMakeOrganizer'])->name('events.admin.attendees.organizer.make');
    Route::get('/events/{eventId}/admin/attendees/{attendeeId}/organizer/remove', [AttendeeController::class, 'doRemoveOrganizer'])->name('events.admin.attendees.organizer.remove');

    Route::get('/events/{eventId}/admin/eventSettings', [EventSettingsController::class, 'showIndex'])->name('events.admin.eventSettings');
    Route::post('/events/{eventId}/admin/eventSettings', [EventSettingsController::class, 'doSave'])->name('events.admin.eventSettings.doSave');
    Route::post('/events/{eventId}/admin/eventSettings/logo', [EventSettingsController::class, 'doSaveLogo'])->name('events.admin.eventSettings.doSaveLogo');
    Route::get('/events/{eventId}/admin/eventSettings/clearLogo', [EventSettingsController::class, 'doClearLogo'])->name('events.admin.eventSettings.doClearLogo');

    Route::get('/events/{eventId}/admin/rooms', [RoomController::class, 'showIndex'])->name('events.admin.rooms');
    Route::post('/events/{eventId}/admin/rooms/create', [RoomController::class, 'doCreate'])->name('events.admin.rooms.create');
    Route::post('/events/{eventId}/admin/rooms/{roomId}/update', [RoomController::class, 'doUpdate'])->name('events.admin.rooms.update');
    Route::get('/events/{eventId}/admin/rooms/{roomId}/delete', [RoomController::class, 'doDelete'])->name('events.admin.rooms.delete');
    Route::get('/events/{eventId}/admin/rooms/{roomId}', [RoomController::class, 'showDetail'])->name('events.admin.rooms.detail');
    Route::post('/events/{eventId}/admin/rooms/{roomId}/slots/setup', [RoomController::class, 'doSetupSlots'])->name('events.admin.rooms.slots.setup');
    Route::get('/events/{eventId}/admin/rooms/{roomId}/slots/{slotId}/delete', [RoomController::class, 'doDeleteSlot'])->name('events.admin.rooms.slots.delete');
    Route::get('/events/{eventId}/admin/rooms/{roomId}/slots/{slotId}/changeState/{state}', [RoomController::class, 'doChangeStateSlot'])->name('events.admin.rooms.slots.changeState');
    Route::post('/events/{eventId}/admin/rooms/{roomId}/slots/create', [RoomController::class, 'doCreateSlot'])->name('events.admin.rooms.slots.create');
});
