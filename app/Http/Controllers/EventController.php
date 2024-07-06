<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    public function showOverview(): Response {
        $publicEvents = Event::where(['state' => 'public'])->get();

        return Inertia::render('Event/Overview', [
            "events" => $publicEvents,
        ]);
    }

    public function showDetail(string $eventId): Response {
        $event = Event::findOrFail($eventId);
        $attendee = Attendee::where(['event_id' => $eventId, 'user_id' => Auth::user()->id])->first();

        return Inertia::render('Event/Detail', [
            'event' => $event,
            'attendee' => $attendee ?? false,
        ]);
    }

    public function showAgenda(string $eventId): Response {
        // TODO: Show all confirmed room invites
        return Inertia::render('Event/Agenda');
    }

    public function showNotes(string $eventId): Response {
        // TODO: Show all notes from the event organizers
        return Inertia::render('Event/Notes');
    }

    public function showNotifications(string $eventId): Response {
        // TODO: Show all notifications from system events for the authenticated user
    }

    public function doEnroll(string $eventId): RedirectResponse {
        // TODO: Create attendee profile for the authenticated user and redirect to event detail page
    }

    public function doLeave(string $eventId): RedirectResponse {
        // TODO: Mark the authenticated users attendee profile as deleted and redirect to event detail page
    }
}
