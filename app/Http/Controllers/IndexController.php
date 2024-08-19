<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class IndexController extends Controller
{
    public function showIndex(): Response {
        // TODO: Show a simple landing page advertising Lumetra as a project
        return Inertia::render('Index');
    }

    public function showSettings(string $eventId = null): Response {
        $user = Auth::user();
        $user->load(["attendees", "attendees.event"]);
        $userAttendee = null;
        $event = null;

        if($eventId) {
            $userAttendee = Attendee::where(['user_id' => Auth::user()->id, 'event_id' => $eventId])->with(['contact_infos'])->firstOrFail();
            $event = Event::findOrFail($eventId);
        }

        return Inertia::render('Settings', [
            'user' => $user,
            'event' => $event,
            'attendee' => $userAttendee,
        ]);
    }

    public function doSaveSettings(string $eventId): RedirectResponse {
        // TODO: Save attendee profile settings and general user settings
    }
}
