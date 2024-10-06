<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveRoomRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RoomController extends Controller
{
    public function showIndex(string $eventId): Response {
        $event = Event::findOrFail($eventId);
        $event->load(['rooms', 'rooms.slots']);

        return Inertia::render('Admin/Room/Index', [
            'event' => $event,
        ]);
    }

    public function showDetail(string $eventId, string $roomId): Response {
        $event = Event::findOrFail($eventId);
        $room = $event->rooms()->findOrFail($roomId);

        return Inertia::render('Admin/Room/Detail', [
            'event' => $event,
            'room' => $room,
        ]);
    }

    public function doCreate(string $eventId, SaveRoomRequest $request): RedirectResponse {
        $event = Event::findOrFail($eventId);

        $event->rooms()->create([
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

    public function doDelete(string $eventId, string $roomId): RedirectResponse {
        $event = Event::findOrFail($eventId);
        $room = $event->rooms()->findOrFail($roomId);

        $room->delete();

        return redirect(route('events.admin.rooms', [
            'eventId' => $event->id
        ]));
    }

    public function doUpdate(string $eventId, string $roomId, SaveRoomRequest $request): RedirectResponse {
        $event = Event::findOrFail($eventId);
        $room = $event->rooms()->findOrFail($roomId);

        $room->update([
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
