<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRoomSlot;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    public function showIndex(string $eventId): Response {
        $user = Auth::user();
        $event = Event::findOrFail($eventId);
        $event->load(['attendees']);

        $eventRoomSlotCount = EventRoomSlot::count();
        $eventRemainingDays = $event->remaining_days;

        return Inertia::render('Admin/Index', [
            'event' => $event,
            'eventRoomSlotCount' => $eventRoomSlotCount,
            'eventRemainingDays' => $eventRemainingDays,
        ]);
    }
}
