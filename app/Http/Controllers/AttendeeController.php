<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AttendeeController extends Controller
{
    public function showOverview(string $eventId): Response {
        // TODO: Show a short preview of public attendee profiles and a search
    }

    public function showDetail(string $eventId, string $attendeeId): Response {
        $event = Event::findOrFail($eventId);
        $userAttendee = Attendee::where(['event_id' => $eventId, 'user_id' => Auth::user()->id, 'active' => true])->firstOrFail();
        $attendee = Attendee::where(['id' => $attendeeId, 'active' => true])->firstOrFail();

        return Inertia::render('Attendee/Detail', [
            'event' => $event,
            'userAttendee' => $userAttendee ?? false,
            'attendee' => $attendee,
        ]);
    }

    public function doConnect(string $eventId, string $attendeeId): RedirectResponse {
        // TODO: If ConnectRequest exists: Remove ConnectRequest and connect authenticated user with $attendeeId
        // TODO: If no ConnectRequest exists: Create a Connect Request to $attendeeId from the authenticated user and redirect to attendee detail page
    }

    public function doDisconnect(string $eventId, string $attendeeId): RedirectResponse {
        // TODO: If ConnectRequest exists: Remove ConnectRequest
        // TODO: Always: Disconnect authenticated user from $attendeeId and redirect to attendee detail page
    }

    public function showSettings(string $eventId): Response {
        // TODO: Show attendee profile settings and general user settings
    }

    public function doSaveSettings(string $eventId): RedirectResponse {
        // TODO: Save attendee profile settings and general user settings
    }
}
