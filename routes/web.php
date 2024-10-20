<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// GENERAL
Route::get('/', [IndexController::class, 'showIndex'])->name('index');

// EVENTS
Route::get('/events', [EventController::class, 'showOverview'])->name('events.index');
Route::get('/events/{eventId}', [EventController::class, 'showDetail'])->name('events.detail');

Route::middleware('auth')->group(function () {
    Route::get('/events/{eventId}/agenda', [EventController::class, 'showAgenda'])->name('events.detail.agenda');
    Route::get('/events/{eventId}/enroll', [EventController::class, 'doEnroll'])->name('events.detail.enroll');
    Route::get('/events/{eventId}/leave', [EventController::class, 'doLeave'])->name('events.detail.leave');
});

// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/settings', [IndexController::class, 'showGlobalSettings'])->name('settings.global');
    Route::post('/settings', [IndexController::class, 'doSaveGlobalSettings'])->name('settings.global');

    Route::get('/settings/{eventId}', [IndexController::class, 'showEventSettings'])->name('settings.event');
    Route::post('/settings/{eventId}/name', [IndexController::class, 'doSaveEventNameSettings'])->name('settings.event.name');
    Route::post('/settings/{eventId}/avatar', [IndexController::class, 'doSaveEventAvatarSettings'])->name('settings.event.avatar');
    Route::get('/settings/{eventId}/clearAvatar', [IndexController::class, 'doClearEventAvatarSettings'])->name('settings.event.avatar.clear');
    Route::post('/settings/{eventId}/description', [IndexController::class, 'doSaveEventDescriptionSettings'])->name('settings.event.description');
    Route::post('/settings/{eventId}/socialLink/create', [IndexController::class, 'doCreateEventSocialLink'])->name('settings.event.socialLink.create');
    Route::get('/settings/{eventId}/socialLink/remove/{socialLinkId}', [IndexController::class, 'doRemoveEventSocialLink'])->name('settings.event.socialLink.remove');

    Route::get('/events/{eventId}/attendees', [AttendeeController::class, 'showOverview'])->name('events.attendees.index');
    Route::get('/events/{eventId}/attendees/search', [AttendeeController::class, 'search'])->name('events.attendees.search');
    Route::get('/events/{eventId}/attendees/{attendeeId}', [AttendeeController::class, 'showDetail'])->name('events.attendees.detail');

    Route::post('/events/{eventId}/attendees/{attendeeId}/connect', [AttendeeController::class, 'doConnect'])->name('events.attendees.connect');
    Route::post('/events/{eventId}/attendees/{attendeeId}/disconnect', [AttendeeController::class, 'doDisconnect'])->name('events.attendees.disconnect');

    Route::get('/events/{eventId}/attendees/{attendeeId}/acceptRequest/{requestId}', [AttendeeController::class, 'doAcceptRequest'])->name('events.attendees.connect.accept');
    Route::get('/events/{eventId}/attendees/{attendeeId}/declineRequest/{requestId}', [AttendeeController::class, 'doDeclineRequest'])->name('events.attendees.connect.decline');
});

// CHATS
Route::middleware('auth')->group(function () {
    Route::get('/events/{eventId}/chats', [ChatController::class, 'showOverview'])->name('events.chats.index');
    Route::get('/events/{eventId}/chats/{attendeeId}', [ChatController::class, 'showDetail'])->name('events.chats.detail');
    Route::get('/events/{eventId}/chats/{attendeeId}/receive', [ChatController::class, 'getChat'])->name('events.chats.receive');
    Route::post('/events/{eventId}/chats/{attendeeId}/sendMessage', [ChatController::class, 'doSendMessage'])->name('events.chats.sendMessage');
    Route::get('/events/{eventId}/chats/{attendeeId}/roomSlotInvite/{slotId}/send', [ChatController::class, 'doRoomSlotInviteSend'])->name('events.chats.roomSlotInvite.send');
    Route::get('/events/{eventId}/chats/{attendeeId}/roomSlotInvite/{inviteId}/{acceptInvite}', [ChatController::class, 'doRoomSlotInviteAnswer'])->name('events.chats.roomSlotInvite.answer');
});

// ROOMS
Route::middleware('auth')->group(function () {
    Route::get('/events/{eventId}/rooms/{date}', [ChatController::class, 'getRooms'])->name('events.rooms.index');
});

// NOTIFICATIONS
Route::middleware('auth')->group(function () {
    Route::get('/events/{eventId}/notifications/{notificationId}/clear', [NotificationController::class, 'doClearNotification'])->name('events.notifications.clear');
});

// AUTH
require __DIR__.'/auth.php';

// ADMIN
require __DIR__.'/admin.php';
