<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    public function showOverview(): Response {
        // TODO: Show all visible events
    }

    public function showDetail(string $eventId): Response {
        // TODO: Show a single event and it's metadata
    }

    public function showAgenda(string $eventId): Response {
        // TODO: Show all confirmed room invites
    }

    public function showNotes(string $eventId): Response {
        // TODO: Show all notes from the event organizers
    }

    public function showNotifications(string $eventId): Response {
        // TODO: Show all notifications from system events for the authenticated user
    }

    public function doEnroll(string $eventId): RedirectResponse {
        // TODO: Create attendee profile for the authenticated user and redirect to event detail page
    }

    public function doLeave(string $eventId): RedirectResponse {
        // TODO: Mark the authenticated users attendee profile as deleted and redirect to event detail page
    }
}
