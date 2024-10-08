<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendee;
use Symfony\Component\HttpFoundation\Response;

class ConfirmationRequired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $eventId = $request->route('eventId');

        if (!Auth::user() ||
            $eventId === null ||
            $request->route()->getName() === 'events.confirmation' ||
            $request->route()->getName() === 'events.confirmation.confirm'
        ) {
            return $next($request);
        }

        // Confirmation Check
        $existingAttendee = Attendee::where([
            'user_id' => Auth::id(),
            'event_id' => $eventId
        ])->first();

        if (!$existingAttendee) {
            return $next($request);
        } else {
            if($existingAttendee->confirmed === 0) {
                return redirect()->route('events.confirmation', ['eventId' => $eventId]);
            } else {
                return $next($request);
            }
        }
    }
}
