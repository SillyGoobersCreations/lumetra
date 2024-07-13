<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventNote;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('[DevSeeder] Start.');

        // USERS
        $userAdmin = User::create([
            'id' => 'a635c284-3b16-4ed0-bab2-54af4f423fb6',
            'email' => 'admin@local',
            'is_admin' => true,
            'is_event_creator' => true,
            'password' => Hash::make('admin'),
        ]);
        $userOrganizer = User::create([
            'id' => '6f41391d-c200-4061-a004-f08ce39d6b82',
            'email' => 'organizer@local',
            'is_event_creator' => true,
            'password' => Hash::make('organizer'),
        ]);
        $userUser = User::create([
            'id' => 'ec809857-ae5d-4f80-9920-98987092acef',
            'email' => 'user@local',
            'password' => Hash::make('user'),
        ]);
        $this->command->comment('[DevSeeder] Created Users');

        // EVENTS
        $eventFirst = Event::create([
            'id' => 'e5509f81-9247-45bb-b7b7-e3723d890826',
            'state' => 'public',
            'title' => 'First Event',
            'organizer' => 'Lumetra',
            'description' => 'This is the first test event',
        ]);
        $eventSecond = Event::create([
            'id' => '656607c6-33c0-4b1e-8972-d106c525fef7',
            'state' => 'public',
            'title' => 'Second Event',
            'organizer' => 'Lumetra',
            'description' => 'This is the second test event.',
        ]);
        $eventDraft = Event::create([
            'id' => 'fcbdaaf0-8aad-4fd8-8f5f-8d2e25347ca2',
            'state' => 'draft',
            'title' => 'Draft Event',
            'organizer' => 'Lumetra',
            'description' => 'This is a draft event.',
        ]);
        $eventHidden = Event::create([
            'id' => '3e527a47-93bf-47cd-8fd1-ed583e6acfb8',
            'state' => 'hidden',
            'title' => 'Hidden Event',
            'organizer' => 'Lumetra',
            'description' => 'This is a hidden event.',
        ]);
        $this->command->comment('[DevSeeder] Created Events');

        // EVENT NOTES
        $eventNote = EventNote::create([
            'id' => 'e78e07c0-38d4-4fad-8238-8dc7602dc1ec',
            'event_id' => $eventFirst->id,
            'title' => 'Non sticky Note',
            'text' => 'This is not a sticky note',
            'sticky' => false,
        ]);
        $eventNoteSticky = EventNote::create([
            'id' => '0f17cd6a-8acf-4433-9c7f-df73432b4292',
            'event_id' => $eventFirst->id,
            'title' => 'Sticky Note',
            'text' => 'This is a sticky note',
            'sticky' => true,
        ]);
        $this->command->comment('[DevSeeder] Created Event Notes');

        $this->command->info('[DevSeeder] Done.');
    }
}
