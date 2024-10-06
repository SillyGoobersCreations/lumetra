<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRoomRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
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

    public function doCreate(string $eventId, CreateRoomRequest $request): RedirectResponse {
        $event = Event::findOrFail($eventId);

        $newRoom = $event->rooms()->create([
            'event_id' => $eventId,
            'name' => $request->validated('name'),
            'location' => $request->validated('location'),
            'notes' => $request->validated('notes'),
            'available' => $request->validated('available'),
        ]);

        return redirect(route('events.admin.rooms', [
            'eventId' => $event->id
        ]));
    }
}
