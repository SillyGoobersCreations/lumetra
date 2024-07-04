<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// GENERAL
Route::get('/', [IndexController::class, 'showIndex'])->name('index');

// EVENTS
Route::get('/events', [EventController::class, 'showOverview'])->name('events.index');
Route::get('/events/{eventId}', [EventController::class, 'showDetail'])->name('events.detail');
Route::get('/events/{eventId}/notes', [EventController::class, 'showNotes'])->name('events.detail.notes');

Route::middleware('auth')->group(function () {
    Route::get('/events/{eventId}/agenda', [EventController::class, 'showAgenda'])->name('events.detail.agenda');
    Route::get('/events/{eventId}/notifications', [EventController::class, 'showNotifications'])->name('events.detail.notifications');
    Route::post('/events/{eventId}/enroll', [EventController::class, 'doEnroll'])->name('events.detail.enroll');
    Route::post('/events/{eventId}/leave', [EventController::class, 'doLeave'])->name('events.detail.leave');

    Route::get('/events/{eventId}/settings', [ProfileController::class, 'showSettings'])->name('events.settings');
    Route::post('/events/{eventId}/settings', [ProfileController::class, 'doSaveSettings']);
});

// PROFILE
Route::get('/events/{eventId}/attendees', [ProfileController::class, 'showOverview'])->name('events.attendees.index');
Route::get('/events/{eventId}/attendees/{userId}', [ProfileController::class, 'showDetail'])->name('events.attendees.detail');

Route::middleware('auth')->group(function () {
    Route::post('/events/{eventId}/attendees/{userId}/connect', [ProfileController::class, 'doConnect'])->name('events.attendees.connect');
    Route::post('/events/{eventId}/attendees/{userId}/disconnect', [ProfileController::class, 'doDisconnect'])->name('events.attendees.disconnect');
});

// CHATS
Route::middleware('auth')->group(function () {
    Route::get('/events/{eventId}/chats', [ChatController::class, 'showOverview'])->name('events.chats.index');
    Route::get('/events/{eventId}/chats/{userId}', [ChatController::class, 'showDetail'])->name('events.chats.detail');
    Route::get('/events/{eventId}/chats/{userId}/receive', [ChatController::class, 'getChat'])->name('events.chats.receive');
    Route::post('/events/{eventId}/chats/{userId}/sendMessage', [ChatController::class, 'doSendMessage'])->name('events.chats.sendMessage');
    Route::post('/events/{eventId}/chats/{userId}/roomSlotInvite/{slotId}/send', [ChatController::class, 'doRoomSlotInviteSend'])->name('events.chats.roomSlotInvite.send');
    Route::post('/events/{eventId}/chats/{userId}/roomSlotInvite/{inviteId}/answer', [ChatController::class, 'doRoomSlotInviteAnswer'])->name('events.chats.roomSlotInvite.answer');
});

// ROOMS
Route::middleware('auth')->group(function () {
    Route::get('/events/{eventId}/rooms', [RoomController::class, 'showOverview'])->name('events.rooms.index');
    Route::get('/events/{eventId}/rooms/{roomId}', [RoomController::class, 'showDetail'])->name('events.rooms.detail');
});

// AUTH
require __DIR__.'/auth.php';
