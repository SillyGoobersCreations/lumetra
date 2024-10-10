<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendee;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $eventId = $request->route('eventId');

        // Admin Check
        if (Auth::user()->is_admin) {
            return $next($request);
        }

        // Organizer Check
        $isOrganizer = Attendee::where([
            'user_id' => Auth::id(),
            'event_id' => $eventId,
            'role' => 'organizer'
        ])->first();

        if ($isOrganizer) {
            return $next($request);
        }

        return response("", 403);
    }
}
