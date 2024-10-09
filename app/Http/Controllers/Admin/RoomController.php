<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRoomSlotRequest;
use App\Http\Requests\Admin\SaveRoomRequest;
use App\Http\Requests\Admin\SetupRoomSlotsRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class RoomController extends Controller
{
    public function showIndex(string $eventId): Response {
        $event = Event::findOrFail($eventId);
        $event->load(['rooms', 'rooms.slots']);

        return Inertia::render('Admin/Room/Index', [
            'event' => $event,
        ]);
    }

    public function showDetail(string $eventId, string $roomId): Response {
        $event = Event::findOrFail($eventId);
        $room = $event->rooms()->with('slots', 'slots.claims', 'slots.claims.inviter_attendee', 'slots.claims.invitee_attendee')->findOrFail($roomId);

        $startDate = Carbon::parse($event->start_date);
        $endDate = Carbon::parse($event->end_date);

        $groupedSlots = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $slotsForTheDay = $room->slots->filter(function ($slot) use ($date) {
                $startDate = Carbon::parse($slot->start_date);
                return $startDate->isSameDay($date);
            });

            $groupedSlots[$date->format('Y-m-d')] = $slotsForTheDay->values();
        }

        return Inertia::render('Admin/Room/Detail', [
            'event' => $event,
            'room' => $room,
            'groupedSlots' => $groupedSlots,
        ]);
    }

    public function doCreate(string $eventId, SaveRoomRequest $request): RedirectResponse {
        $event = Event::findOrFail($eventId);

        $event->rooms()->create([
            'event_id' => $eventId,
            'name' => $request->validated('name'),
            'location' => $request->validated('location'),
            'notes' => $request->validated('notes'),
            'available' => $request->validated('available'),
        ]);

        return redirect(route('events.admin.rooms', [
            'eventId' => $event->id
        ]));
    }

    public function doDelete(string $eventId, string $roomId): RedirectResponse {
        $event = Event::findOrFail($eventId);
        $room = $event->rooms()->findOrFail($roomId);

        $room->delete();

        return redirect(route('events.admin.rooms', [
            'eventId' => $event->id
        ]));
    }

    public function doUpdate(string $eventId, string $roomId, SaveRoomRequest $request): RedirectResponse {
        $event = Event::findOrFail($eventId);
        $room = $event->rooms()->findOrFail($roomId);

        $room->update([
            'name' => $request->validated('name'),
            'location' => $request->validated('location'),
            'notes' => $request->validated('notes'),
            'available' => $request->validated('available'),
        ]);

        return redirect(route('events.admin.rooms', [
            'eventId' => $event->id
        ]));
    }

    public function doSetupSlots(string $eventId, string $roomId, SetupRoomSlotsRequest $request): RedirectResponse
    {
        $event = Event::findOrFail($eventId);
        $room = $event->rooms()->with('slots')->findOrFail($roomId);

        $data = $request->validated();

        $startHour = $data['start_hour'];
        $startMinute = $data['start_minute'];
        $endHour = $data['end_hour'];
        $endMinute = $data['end_minute'];
        $duration = $data['duration'];
        $timeBetweenSlots = $data['time_between_slots'];

        // Use the event's start date to initialize the slots
        $date = Carbon::parse($data['date']);

        $startTime = $date->copy()->setTime($startHour, $startMinute);
        $endTime = $date->copy()->setTime($endHour, $endMinute);

        $currentTime = $startTime->copy();

        $slots = [];

        while ($currentTime->copy()->addMinutes($duration)->lessThanOrEqualTo($endTime)) {
            $slotEndTime = $currentTime->copy()->addMinutes($duration);

            $slots[] = [
                'start_date' => $currentTime->toDateTimeString(),
                'end_date' => $slotEndTime->toDateTimeString(),
            ];

            $currentTime->addMinutes($duration + $timeBetweenSlots);
        }

        foreach ($slots as $slot) {
            $room->slots()->create([
                'start_date' => $slot['start_date'],
                'end_date' => $slot['end_date'],
                'event_room_id' => $room->id,
                'state' => 'open',
            ]);
        }

        return redirect(route('events.admin.rooms.detail', [
            'eventId' => $event->id,
            'roomId' => $room->id,
        ]));
    }

    public function doDeleteSlot(string $eventId, string $roomId, string $slotId): RedirectResponse
    {
        $event = Event::findOrFail($eventId);
        $room = $event->rooms()->with('slots')->findOrFail($roomId);
        $slot = $room->slots()->findOrFail($slotId);

        $slot->delete();

        return redirect(route('events.admin.rooms.detail', [
            'eventId' => $event->id,
            'roomId' => $room->id,
        ]));
    }

    public function doChangeStateSlot(string $eventId, string $roomId, string $slotId, string $state): RedirectResponse
    {
        $event = Event::findOrFail($eventId);
        $room = $event->rooms()->with('slots')->findOrFail($roomId);
        $slot = $room->slots()->findOrFail($slotId);

        $slot->update([
            'state' => $state,
        ]);

        return redirect(route('events.admin.rooms.detail', [
            'eventId' => $event->id,
            'roomId' => $room->id,
        ]));
    }

    public function doCreateSlot(string $eventId, string $roomId, CreateRoomSlotRequest $request): RedirectResponse
    {
        $event = Event::findOrFail($eventId);
        $room = $event->rooms()->with('slots')->findOrFail($roomId);

        $start_date = Carbon::parse($event->start_date)
            ->setHour($request->validated('start_hour'))
            ->setMinute($request->validated('start_minute'))
            ->setSecond(0);

        $end_date = Carbon::parse($event->start_date)
            ->setHour($request->validated('end_hour'))
            ->setMinute($request->validated('end_minute'))
            ->setSecond(0);

        $slot = $room->slots()->create([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'event_room_id' => $room->id,
            'state' => $request->validated('state'),
            'notes' => $request->validated('notes'),
        ]);

        return redirect(route('events.admin.rooms.detail', [
            'eventId' => $event->id,
            'roomId' => $room->id,
        ]));
    }
}
