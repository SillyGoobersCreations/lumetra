<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveLogoSettingsRequest;
use App\Http\Requests\Admin\SaveSettingsRequest;
use App\Http\Requests\SaveAvatarSettingsEventRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Nette\Utils\Image;

class EventSettingsController extends Controller
{
    public function showIndex(string $eventId): Response {
        $user = Auth::user();
        $event = Event::findOrFail($eventId);

        return Inertia::render('Admin/EventSettings/Index', [
            'event' => $event,
        ]);
    }

    public function doSave(SaveSettingsRequest $request, string $eventId): RedirectResponse {
        $event = Event::findOrFail($eventId);
        $data = $request->validated();

        $event->update($data);
        $event->save();

        return redirect(route('events.admin.eventSettings', ['eventId' => $eventId]));
    }

    public function doSaveLogo(SaveLogoSettingsRequest $request, string $eventId): RedirectResponse {
        $event = Event::findOrFail($eventId);

        $logoFile = $request->validated('logo');
        $extension = $logoFile->getClientOriginalExtension();
        $filename = "$event->id.$extension";

        $image = Image::fromFile($logoFile->getRealPath());
        $image->resize(600, 60, Image::OrSmaller);
        $image->save(Storage::disk('logos')->path("$filename"));

        $event->logo = $filename;
        $event->save();

        return redirect(route('events.admin.eventSettings', ['eventId' => $eventId]));
    }

    public function doClearLogo(string $eventId): RedirectResponse {
        $event = Event::findOrFail($eventId);

        Storage::disk('logos')->delete($event->logo);

        $event->logo = null;
        $event->save();

        return redirect(route('events.admin.eventSettings', ['eventId' => $eventId]));
    }
}
