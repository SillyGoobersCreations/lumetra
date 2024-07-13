<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class RoomController extends Controller
{
    public function showOverview(string $eventId): Response {
        // TODO: Show all visible rooms for the event
    }

    public function showDetail(string $eventId, string $roomId): Response {
        // TODO: Show all slots and their availability of a room and metadata of the room
    }

    public function getSlots(string $eventId, string $roomId): Response {
        // TODO: Return JSON with the available slots from the room
    }
}
