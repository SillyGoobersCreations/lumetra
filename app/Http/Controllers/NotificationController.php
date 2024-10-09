<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{

    public function doClearNotification(string $eventId, string $notificationid): RedirectResponse
    {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->firstOrFail();
        $notification = $userAttendee->notifications()->findOrFail($notificationid);

        $notification->delete();

        if($notification->link) {
            return redirect($notification->link);
        } else {
            return redirect()->back();
        }
    }
}
