<?php

namespace App\Http\Middleware;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $userAttendees = [];
        if($request->user() != null) {
            $userAttendees = Attendee::where(['user_id' => Auth::user()->id])->with(['event'])->get();
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'attendees' => $userAttendees,
            ],
        ];
    }
}
