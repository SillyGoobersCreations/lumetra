<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendeeDoConnectRequest;
use App\Models\Attendee;
use App\Models\AttendeeConnection;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AttendeeController extends Controller
{
    public function showOverview(string $eventId): Response {
        $event = Event::findOrFail($eventId);

        return Inertia::render('Attendee/Overview', [
            'event' => $event,
        ]);
    }

    public function showDetail(string $eventId, string $attendeeId): Response {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->first();
        $event = Event::findOrFail($eventId);
        $attendee = Attendee::where(['id' => $attendeeId])->with(['event', 'contact_infos'])->firstOrFail();
        $attendeeConnection = AttendeeConnection::checkConnection($userAttendee->id, $attendee->id)->first();

        $filteredContactInfos = $attendee->contact_infos->filter(function($contactInfo) use ($userAttendee, $attendee, $attendeeConnection) {
            if ($contactInfo->visibility == 'public') {
                return true;
            } elseif ($contactInfo->visibility == 'hidden') {
                return $userAttendee->id === $attendee->id;
            } elseif ($contactInfo->visibility == 'connections_only') {
                return $attendeeConnection !== null || $userAttendee->id === $attendee->id;
            }
            return false;
        })->values();

        return Inertia::render('Attendee/Detail', [
            'event' => $event,
            'attendee' => $attendee,
            'contactInfos' => $filteredContactInfos,
            'connection' => $attendeeConnection,
        ]);
    }

    public function search(Request $request, string $eventId): JsonResponse {
        $query = $request->query('query');
        $sortBy = $request->query('sortBy');
        $sortType = $request->query('sortType') ?? "DESC";

        //dd($sortType);

        $attendees = Attendee::search(trim($query))
            ->where('event_id', $eventId)
            ->orderBy($sortBy, $sortType)
            ->take(1000) // TODO: Add proper pagination
            ->get();

        return response()->json($attendees);
    }

    public function doConnect(AttendeeDoConnectRequest $request, string $eventId, string $attendeeId): RedirectResponse {
        $user = Auth::user();
        $inviterAttendee = Attendee::where(['user_id' => Auth::user()->id, 'event_id' => $eventId])->firstOrFail();
        $inviteeAttendee = Attendee::where(['id' => $attendeeId, 'event_id' => $eventId])->firstOrFail();

        $newRequest = AttendeeConnection::create([
            'inviter_attendee_id' => $inviterAttendee->id,
            'invitee_attendee_id' => $inviteeAttendee->id,
            'state' => AttendeeConnection::STATE_PENDING,
            'intro_text' => $request->validated('intro_text'),
        ]);

        $inviteeAttendee->notifications()->create([
            'type' => 'connection_new',
            'text' => 'You received a new connection request from ' . $inviterAttendee->name_full,
            'link' => route('events.chats.detail', [
                'eventId' => $eventId,
                'attendeeId' => $inviterAttendee->id,
            ]),
        ]);

        return Redirect::route('events.attendees.detail', ['eventId' => $eventId, 'attendeeId' => $attendeeId]);
    }

    public function doDisconnect(string $eventId, string $attendeeId): RedirectResponse {
        $user = Auth::user();
        $inviterAttendee = Attendee::where(['user_id' => Auth::user()->id, 'event_id' => $eventId])->firstOrFail();
        $inviteeAttendee = Attendee::where(['id' => $attendeeId, 'event_id' => $eventId])->firstOrFail();

        // If AttendeeConnection between these two attendees exists, remove it
        AttendeeConnection::checkConnection($inviterAttendee->id, $inviteeAttendee->id)->delete();

        return Redirect::route('events.attendees.detail', ['eventId' => $eventId, 'attendeeId' => $attendeeId]);
    }

    public function doAcceptRequest(string $eventId, string $attendeeId, string $requestId): RedirectResponse {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->firstOrFail();
        $request = AttendeeConnection::findOrFail($requestId);
        $inviterAttendee = Attendee::where(['id' => $attendeeId, 'event_id' => $eventId])->firstOrFail();

        if($request->invitee_attendee_id != $userAttendee->id) {
            abort(403, "Only the invitee can accept the request.");
        }

        $request->state = AttendeeConnection::STATE_CONFIRMED;
        $request->save();

        $inviterAttendee->notifications()->create([
            'type' => 'connection_answer',
            'text' => $userAttendee->name_full . ' accepted your connection request',
            'link' => route('events.chats.detail', [
                'eventId' => $eventId,
                'attendeeId' => $userAttendee->id,
            ]),
        ]);

        return Redirect::route('events.attendees.detail', ['eventId' => $eventId, 'attendeeId' => $request->inviter_attendee_id]);
    }

    public function doDeclineRequest(string $eventId, string $attendeeId, string $requestId): RedirectResponse {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->firstOrFail();
        $request = AttendeeConnection::findOrFail($requestId);

        if($request->invitee_attendee_id != $userAttendee->id) {
            abort(403, "Only the invitee can decline the request.");
        }

        $request->state = AttendeeConnection::STATE_DECLINED;
        $request->save();

        return Redirect::route('events.attendees.detail', ['eventId' => $eventId, 'attendeeId' => $request->inviter_attendee_id]);
    }
}
