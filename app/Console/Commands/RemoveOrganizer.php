<?php

namespace App\Console\Commands;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Console\Command;

class RemoveOrganizer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lumetra:organizer:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes organizer permissions from an attendee';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::all();
        $eventsToSelect = ['' => ''];
        foreach ($events as $event) {
            $eventsToSelect[] = $event->id . ' - ' . $event->title;
        }

        $eventIndex = $this->choice('Select an event', $eventsToSelect);
        $eventId = $events[$eventIndex]->id;

        $userHandle = $this->ask('User Handle');

        $attendee = Attendee::where([
            'event_id' => $eventId,
            'handle' => $userHandle,
        ])->first();

        if(!$attendee) {
            $this->error('Attendee not found');
            return;
        }

        $attendee->update([
            'role' => 'attendee',
        ]);

        $this->info('Removed organizer permissions from ' . $attendee->name_full);
    }
}
