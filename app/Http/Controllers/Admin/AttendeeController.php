<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class AttendeeController extends Controller
{
    public function showOverview(string $eventId): Response {
        $user = Auth::user();
        $event = Event::findOrFail($eventId);
        $event->load(['attendees', 'attendees.user']);

        return Inertia::render('Admin/Attendee/Overview', [
            'event' => $event,
        ]);
    }

    public function doConfirmConfirmation(string $eventId, string $attendeeId): RedirectResponse {
        $attendee = Attendee::where(['id' => $attendeeId, 'event_id' => $eventId])->firstOrFail();

        $attendee->confirmed = true;
        $attendee->save();

        return Redirect::route('events.admin.attendees', ['eventId' => $eventId]);
    }

    public function doRevokeConfirmation(string $eventId, string $attendeeId): RedirectResponse {
        $attendee = Attendee::where(['id' => $attendeeId, 'event_id' => $eventId])->firstOrFail();

        $attendee->confirmed = false;
        $attendee->save();

        return Redirect::route('events.admin.attendees', ['eventId' => $eventId]);
    }
}
