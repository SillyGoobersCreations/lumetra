<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Inertia\Inertia;
use Inertia\Response;

class RoomController extends Controller
{
    public function showIndex(string $eventId): Response {
        $event = Event::findOrFail($eventId);
        $event->load(['rooms']);

        return Inertia::render('Admin/Room/Index', [
            'event' => $event,
        ]);
    }
}
