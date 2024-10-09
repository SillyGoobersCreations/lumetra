<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class CreateEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lumetra:event:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new event';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $title = $this->ask('Event title');
        $organizer = $this->ask('Organizer');

        $newEvent = Event::create([
            'state' => 'draft',
            'title' => $title,
            'organizer' => $organizer,
        ]);

        $this->info('Event was created successfully! ID: ' . $newEvent->id);
        $this->info('Access Link: ' . route('events.detail', ['eventId' => $newEvent->id]));
    }
}
