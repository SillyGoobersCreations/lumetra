<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('scout:flush', [
            'model' => Attendee::class,
        ]);
        $this->command->comment('[DatabaseSeeder] Cleared Meilisearch Indexes');

        $this->call(DefaultSeeder::class);

        if(app()->environment('local')) {
            $this->call(DevSeeder::class);
        }

        Artisan::call('scout:sync-index-settings');
        Artisan::call('scout:import', [
            'model' => Attendee::class,
        ]);
        $this->command->comment('[DatabaseSeeder] Reimported Meilisearch Indexes');
    }
}
