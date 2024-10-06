<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class RoomController extends Controller
{
    public function getSlots(string $eventId, string $roomId): Response {
        // TODO: Return JSON with the available slots from the room
    }
}
