<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\ChatMessage;
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

        if(Auth::user()) {
            $userAttendee = Attendee::where(['event_id' => $eventId, 'user_id' => Auth::user()->id, 'active' => true])->first();

            $lastThreeChats = [];
            if ($userAttendee) {
                $lastThreeChats = ChatMessage::where(['sender_attendee_id' => $userAttendee->id])->orWhere(['receiver_attendee_id' => $userAttendee->id])->where('is_room_slot_invite', false)->with(['sender_attendee', 'receiver_attendee'])->orderBy('created_at', 'desc')->take(3)->get();
            }
        }

        $confirmedAttendeesCount = Attendee::where(['event_id' => $eventId, 'confirmed' => true])->count();
        $canJoin = $event->attendees_max == null || $confirmedAttendeesCount < $event->attendees_max;

        return Inertia::render('Event/Detail', [
            'event' => $event,
            'canJoin' => $canJoin,
            'lastThreeChats' => $lastThreeChats ?? [],
            'userAttendee' => $userAttendee ?? false,
        ]);
    }

    public function showAgenda(string $eventId): Response {
        $event = Event::findOrFail($eventId);

        // TODO: Show all confirmed room invites

        return Inertia::render('Event/Agenda', [
            'event' => $event,
        ]);
    }

    public function showNotifications(string $eventId): Response {
        // TODO: Show all notifications from system events for the authenticated user
    }

    public function doEnroll(string $eventId): RedirectResponse {
        $user = Auth::user();
        $existingEnrollment = Attendee::where(['event_id' => $eventId, 'user_id' => $user->id])->first();
        $event = Event::findOrFail($eventId);

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
            $newEnrollment = Attendee::create([
                'handle' => $user->id,
                'user_id' => $user->id,
                'event_id' => $eventId,
                'active' => true,
                'confirmed' => $event->confirmation_required ? false : true,
                'confirmation_key' => $this->generateConfirmationKey(3, 3),
            ]);

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

    function generateConfirmationKey($segments = 3, $segmentLength = 3) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $key = [];

        for ($i = 0; $i < $segments; $i++) {
            $segment = '';
            for ($j = 0; $j < $segmentLength; $j++) {
                $segment .= $characters[rand(0, strlen($characters) - 1)];
            }
            $key[] = $segment;
        }

        return implode('-', $key);
    }
}
