<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveAvatarSettingsEventRequest;
use App\Http\Requests\SaveConfirmationSettingsEventRequest;
use App\Http\Requests\SaveDescriptionSettingsEventRequest;
use App\Http\Requests\SaveNameSettingsEventRequest;
use App\Http\Requests\SaveSettingsGlobalRequest;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Nette\Utils\Image;

class IndexController extends Controller
{
    public function showIndex(): Response {
        // TODO: Show a simple landing page advertising Lumetra as a project
        return Inertia::render('Index');
    }

    public function showGlobalSettings(): Response {
        $user = Auth::user();
        $user->load(["attendees", "attendees.event"]);

        return Inertia::render('Settings/Global', [
            'user' => $user,
        ]);
    }

    public function showEventSettings(string $eventId): Response {
        $user = Auth::user();
        $user->load(["attendees", "attendees.event"]);
        $userAttendee = Attendee::where(['user_id' => Auth::user()->id, 'event_id' => $eventId])->with(['contact_infos'])->firstOrFail();
        $event = Event::findOrFail($eventId);

        return Inertia::render('Settings/Event', [
            'user' => $user,
            'event' => $event,
            'attendee' => $userAttendee,
        ]);
    }

    public function doSaveGlobalSettings(SaveSettingsGlobalRequest $request): RedirectResponse {
        $user = Auth::user();

        $newEmail = $request->validated('email');
        $currentPassword = $request->validated('current_password');
        $newPassword = $request->validated('password');

        if(!Hash::check($currentPassword, $user->password)) {
            return Redirect::back()->withErrors(['current_password' => 'Your current password does not match.']);
        }

        if($user->email != $newEmail) {
            $user->email = $newEmail;
        }

        if($newPassword != null) {
            $user->password = Hash::make($newPassword);
        }

        $user->save();
        return redirect(route('settings.global'));
    }

    public function doSaveEventNameSettings(SaveNameSettingsEventRequest $request, string $eventId): RedirectResponse {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->firstOrFail();

        $userAttendee->handle = $request->validated('handle');
        $userAttendee->first_name = $request->validated('first_name');
        $userAttendee->last_name = $request->validated('last_name');

        $userAttendee->save();
        return redirect(route('settings.event', ['eventId' => $eventId]));
    }

    public function doSaveEventAvatarSettings(SaveAvatarSettingsEventRequest $request, string $eventId): RedirectResponse {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->firstOrFail();

        $avatarFile = $request->validated('avatar');
        $extension = $avatarFile->getClientOriginalExtension();
        $filename = "$userAttendee->id.$extension";

        $image = Image::fromFile($avatarFile->getRealPath());
        $image->resize(350, 350, Image::Cover);
        $image->save(Storage::disk('avatars')->path("$filename"));

        $userAttendee->avatar_url = $filename;
        $userAttendee->save();

        return redirect(route('settings.event', ['eventId' => $eventId]));
    }

    public function doClearEventAvatarSettings(string $eventId): RedirectResponse {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->firstOrFail();

        Storage::disk('avatars')->delete($userAttendee->avatar_url);

        $userAttendee->avatar_url = null;
        $userAttendee->save();

        return redirect(route('settings.event', ['eventId' => $eventId]));
    }

    public function doSaveEventDescriptionSettings(SaveDescriptionSettingsEventRequest $request, string $eventId): RedirectResponse {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->firstOrFail();

        $userAttendee->description = $request->validated('description');
        $userAttendee->job_company = $request->validated('job_company');
        $userAttendee->job_position = $request->validated('job_position');

        $userAttendee->save();
        return redirect(route('settings.event', ['eventId' => $eventId]));
    }

    public function doSaveEventConfirmationSettings(SaveConfirmationSettingsEventRequest $request, string $eventId): RedirectResponse {
        $user = Auth::user();
        $userAttendee = Attendee::where(['user_id' => $user->id, 'event_id' => $eventId])->firstOrFail();

        // TODO: Check and Save Confirmation

        return redirect(route('settings.event', ['eventId' => $eventId]));
    }
}
