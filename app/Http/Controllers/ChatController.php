<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class ChatController extends Controller
{
    public function showOverview(string $eventId): Response {
        // TODO: Show all chats with authenticated user that are enrolled in the same event and have written before
    }

    public function showDetail(string $eventId, string $userId): Response {
        // TODO: Show the chat history with the authenticated user and the user in $userId from the event $eventId
    }

    public function getChat(string $eventId, string $userId): Response {
        // TODO: Respond with the chat history in JSON
    }

    public function doSendMessage(string $eventId, string $userId): Response {
        // TODO: Receives a message to send to the other chat participant
    }

    public function doRoomSlotInviteSend(string $eventId, string $userId, string $slotId): Response {
        // TODO: Create a room slot invite and send it to the other chat participant
    }

    public function doRoomSlotInviteAnswer(string $eventId, string $userId, string $inviteId): Response {
        // TODO: Accept/Decline the invite and send the response to the other chat participant
    }
}
