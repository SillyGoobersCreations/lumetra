<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{

    public function doClearNotification(string $eventId, string $notificationId): RedirectResponse
    {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->firstOrFail();
        $notification = $userAttendee->notifications()->findOrFail($notificationId);

        // Also clear all notifications with the same type and link
        $similarNotifications = $userAttendee->notifications()->where(['type' => $notification->type, 'link' => $notification->link])->get();

        $notification->delete();
        foreach($similarNotifications as $similarNotification) {
            $similarNotification->delete();
        }

        if($notification->link) {
            return redirect($notification->link);
        } else {
            return redirect()->back();
        }
    }
}
