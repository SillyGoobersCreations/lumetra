<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\AttendeeConnection;
use App\Models\ChatMessage;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class ChatController extends Controller
{
    public function showOverview(string $eventId): Response {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => Auth::user()->id, 'event_id' => $eventId])->first();
        $event = Event::findOrFail($eventId);
        $attendeeConnections = AttendeeConnection
            ::where(['inviter_attendee_id' => $userAttendee->id])
            ->orWhere(['invitee_attendee_id' => $userAttendee->id])
            ->with(['inviter_attendee', 'invitee_attendee'])
            ->get();

        return Inertia::render('Chat/Overview', [
            'event' => $event,
            'connections' => $attendeeConnections,
        ]);
    }

    public function showDetail(string $eventId, string $attendeeId): Response {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => Auth::user()->id, 'event_id' => $eventId])->first();
        $event = Event::findOrFail($eventId);
        $attendeeConnections = AttendeeConnection
            ::where(['inviter_attendee_id' => $userAttendee->id])
            ->orWhere(['invitee_attendee_id' => $userAttendee->id])
            ->with(['inviter_attendee', 'invitee_attendee'])
            ->get();
        $attendeeConnection = AttendeeConnection
            ::checkConnection($userAttendee->id, $attendeeId)
            ->with(['inviter_attendee', 'invitee_attendee'])
            ->first();

        return Inertia::render('Chat/Detail', [
            'event' => $event,
            'connections' => $attendeeConnections,
            'selectedConnection' => $attendeeConnection,
        ]);
    }

    public function getChat(string $eventId, string $attendeeId): JsonResponse {
        $userAttendee = Attendee::where(['user_id' => Auth::user()->id, 'event_id' => $eventId])->first();


        $chatMessages = ChatMessage::checkConnection($userAttendee->id, $attendeeId)->orderBy("updated_at", "desc")->get();

        return response()->json(
            $chatMessages
        );
    }

    public function doSendMessage(string $eventId, string $attendeeId): Response {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => Auth::user()->id, 'event_id' => $eventId])->first();

        // TODO Tara: Create a new ChatMessage with the values provided, message needs to be get through a Request (example for requests: AttendeeDoConnectRequest)
        // TODO Tara: Then redirect to the route('events.chats.detail')
        // TODO: Ignore Room Invites for now
    }

    public function doRoomSlotInviteSend(string $eventId, string $attendeeId, string $slotId): Response {
        // TODO: Create a room slot invite and send it to the other chat participant
    }

    public function doRoomSlotInviteAnswer(string $eventId, string $attendeeId, string $inviteId): Response {
        // TODO: Accept/Decline the invite and send the response to the other chat participant
    }
}
