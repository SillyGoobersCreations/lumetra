<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class ConfirmationController extends Controller
{
    public function showConfirmation(string $eventId): Response {
        $event = Event::findOrFail($eventId);
        return Inertia::render('Auth/Confirmation', [
            'event' => $event,
        ]);
    }

    public function doConfirm(string $eventId, Request $request): RedirectResponse {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->first();
        $event = Event::findOrFail($eventId);

        $data = $request->validate([
            'confirmation_key' => ['required']
        ]);

        $isConfirmed = false;
        if($event->confirmation_personalized) {
            $isConfirmed = $data['confirmation_key'] == $userAttendee->confirmation_key;
        } else {
            $isConfirmed = $data['confirmation_key'] == $event->confirmation_key;
        }

        if($isConfirmed) {
            $userAttendee->update(['confirmed' => true]);
            return redirect()->route('events.detail', ['eventId' => $eventId]);
        } else {
            return redirect()->back()->withErrors(['confirmation_key' => 'Invalid confirmation key.']);
        }
    }
}
