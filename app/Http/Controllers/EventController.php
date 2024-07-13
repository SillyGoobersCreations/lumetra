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
        $userAttendee = Attendee::where(['event_id' => $eventId, 'user_id' => Auth::user()->id, 'active' => true])->first();

        return Inertia::render('Event/Detail', [
            'event' => $event,
            'userAttendee' => $userAttendee ?? false,
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
        $user = Auth::user();
        $existingEnrollment = Attendee::where(['event_id' => $eventId, 'user_id' => $user->id])->first();

        if($existingEnrollment != null) {
            // Reactivate
            if(!$existingEnrollment->active) {
                $existingEnrollment->active = true;
                $existingEnrollment->save();
            }

            return redirect(route('events.attendees.detail', [
                'eventId' => $eventId,
                'attendeeId' => $existingEnrollment->id,
            ]));
        } else {
            // Create new Attendee
            $newEnrollment = new Attendee();
            $newEnrollment->handle = $user->id;
            $newEnrollment->user_id = $user->id;
            $newEnrollment->event_id = $eventId;
            $newEnrollment->save();

            return redirect(route('events.attendees.detail', [
                'eventId' => $eventId,
                'attendeeId' => $newEnrollment->id,
            ]));
        }
    }

    public function doLeave(string $eventId): RedirectResponse {
        $user = Auth::user();
        $existingEnrollment = Attendee::where(['event_id' => $eventId, 'user_id' => $user->id])->firstOrFail();

        $existingEnrollment->active = false;
        $existingEnrollment->save();

        return redirect(route('events.detail', [
            'eventId' => $eventId,
        ]));
    }
}
