<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateNoteRequest;
use App\Models\Event;
use App\Models\EventRoomSlot;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class NoteController extends Controller
{
    public function showOverview(string $eventId): Response {
        $event = Event::findOrFail($eventId);
        $event->load(['notes']);

        return Inertia::render('Admin/Note/Overview', [
            'event' => $event,
        ]);
    }

    public function doSetSticky(string $eventId, string $noteId, string $sticky): RedirectResponse
    {
        $event = Event::findOrFail($eventId);

        $event->notes()->findOrFail($noteId)->update([
            'sticky' => $sticky == 'true',
        ]);

        return redirect()->route('events.admin.notes', ['eventId' => $event->id]);
    }

    public function doDelete(string $eventId, string $noteId): RedirectResponse
    {
        $event = Event::findOrFail($eventId);
        $event->notes()->findOrFail($noteId)->delete();

        return redirect()->route('events.admin.notes', ['eventId' => $event->id]);
    }

    public function doCreate(string $eventId, CreateNoteRequest $request): RedirectResponse
    {
        $event = Event::findOrFail($eventId);

        $data = $request->validated();

        $event->notes()->create([
            'title' => $data['title'],
            'text' => $data['text'],
            'sticky' => $data['sticky'],
        ]);

        return redirect()->route('events.admin.notes', ['eventId' => $event->id]);
    }
}
