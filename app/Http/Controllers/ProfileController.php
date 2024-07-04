<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function showOverview(string $eventId): Response {
        // TODO: Show a short preview of public attendee profiles and a search
    }

    public function showDetail(string $eventId, string $userId): Response {
        // TODO: Show the attendee profile of $userId for $eventId
    }

    public function doConnect(string $eventId, string $userId): RedirectResponse {
        // TODO: If ConnectRequest exists: Remove ConnectRequest and connect authenticated user with $userId
        // TODO: If no ConnectRequest exists: Create a Connect Request to $userId from the authenticated user and redirect to attendee detail page
    }

    public function doDisconnect(string $eventId, string $userId): RedirectResponse {
        // TODO: If ConnectRequest exists: Remove ConnectRequest
        // TODO: Always: Disconnect authenticated user from $userId and redirect to attendee detail page
    }

    public function showSettings(string $eventId): Response {
        // TODO: Show attendee profile settings and general user settings
    }

    public function doSaveSettings(string $eventId): RedirectResponse {
        // TODO: Save attendee profile settings and general user settings
    }
}
