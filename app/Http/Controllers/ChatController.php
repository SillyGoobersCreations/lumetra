<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\AttendeeConnection;
use App\Models\ChatMessage;
use App\Models\Event;
use App\Models\EventRoomSlot;
use App\Models\EventRoomSlotClaim;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class ChatController extends Controller
{
    public function showOverview(string $eventId): Response {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->first();
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
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->first();
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
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->first();

        $chatMessages = ChatMessage::
            checkConnection($userAttendee->id, $attendeeId)
            ->orderBy("updated_at", "asc")
            ->get()
            ->map(function ($message) {
                if($message->is_room_slot_invite) {
                    $roomSlotClaim = EventRoomSlotClaim::findOrFail($message->message);
                    $message->message = $roomSlotClaim->load(['slot', 'slot.room'])->toJson();
                }
                return $message;
            });

        return response()->json(
            $chatMessages
        );
    }

    public function doSendMessage(string $eventId, string $attendeeId, Request $request): RedirectResponse {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->first();

        if(AttendeeConnection::checkConnection($userAttendee->id, $attendeeId)->count() == 0) {
            return redirect(route('events.chats.detail', [
                'eventId' => $eventId,
                'attendeeId' => $attendeeId,
            ]));
        }

        $data = $request->validate([
            'message' => ['required']
        ]);

        $newMessage = ChatMessage::create([
            'message' => $data['message'],
            'sender_attendee_id' => $userAttendee->id,
            'receiver_attendee_id' => $attendeeId,
        ]);

        return redirect(route('events.chats.detail', [
            'eventId' => $eventId,
            'attendeeId' => $attendeeId,
        ]));
    }

    public function doRoomSlotInviteSend(string $eventId, string $attendeeId, string $slotId): JsonResponse {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->first();
        $eventRoomSlot = EventRoomSlot::findOrFail($slotId);

        if($eventRoomSlot->state != 'open') {
            return response()->json(['error' => 'Slot cannot be claimed.', 'status' => 403], 403);
        }

        if(AttendeeConnection::checkConnection($userAttendee->id, $attendeeId)->count() == 0) {
            return response()->json(['error' => 'The two attendees do not have a connection. Please connect them first.', 'status' => 403], 403);
        }

        $newSlotClaim = EventRoomSlotClaim::create([
            'state' => 'pending',
            'event_room_slot_id' => $eventRoomSlot->id,
            'inviter_attendee_id' => $userAttendee->id,
            'invitee_attendee_id' => $attendeeId,
        ]);
        $eventRoomSlot->update(['state' => 'claim_open']);

        $newMessage = ChatMessage::create([
            'message' => $newSlotClaim->id,
            'sender_attendee_id' => $userAttendee->id,
            'receiver_attendee_id' => $attendeeId,
            'is_room_slot_invite' => true,
        ]);

        return response()->json([], 200);
    }

    public function doRoomSlotInviteAnswer(string $eventId, string $attendeeId, string $inviteId, string $acceptInvite): RedirectResponse {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->first();
        $roomSlotClaim = EventRoomSlotClaim::with('slot')->findOrFail($inviteId);
        $acceptInvite = $acceptInvite == 'true';

        if($userAttendee->id != $roomSlotClaim->invitee_attendee_id) {
            return redirect(route('events.chats.detail', [
                'eventId' => $eventId,
                'attendeeId' => $attendeeId,
            ]));
        }

        $roomSlotClaim->load('slot', 'slot.room', 'slot.room.event');

        $roomSlotClaim->update([
            'state' => $acceptInvite ? $roomSlotClaim->slot->room->event->room_slot_team_confirmation_required ? 'attendee_confirmed' : 'confirmed' : 'attendee_declined'
        ]);
        $roomSlotClaim->slot->update([
            'state' => $acceptInvite ? 'claimed' : 'open'
        ]);

        return redirect(route('events.chats.detail', [
            'eventId' => $eventId,
            'attendeeId' => $attendeeId,
        ]));
    }

    public function getRooms(string $eventId, string $date): JsonResponse {
        $dateToCompare = Carbon::parse($date);
        $startOfDay = $dateToCompare->copy()->startOfDay();
        $endOfDay = $dateToCompare->copy()->endOfDay();

        // Filter slots to include only those that are on the same day as the given date
        $event = Event::with(['rooms', 'rooms.slots' => function ($query) use ($startOfDay, $endOfDay) {
            $query->whereBetween('start_date', [$startOfDay, $endOfDay]);
        }])->findOrFail($eventId);

        $rooms = $event->rooms;

        return response()->json($rooms);
    }
}
