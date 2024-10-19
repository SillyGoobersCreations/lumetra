<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')
            ->join('attendees', 'attendees.user_id', '=', 'users.id')
            ->update([
                'users.first_name' => DB::raw('attendees.first_name'),
                'users.last_name' => DB::raw('attendees.last_name'),
                'users.avatar_url' => DB::raw('attendees.avatar_url'),
                'users.description' => DB::raw('attendees.description'),
                'users.job_company' => DB::raw('attendees.job_company'),
                'users.job_position' => DB::raw('attendees.job_position'),
            ]);

        DB::table('attendees')->update([
            'first_name' => null,
            'last_name' => null,
            'avatar_url' => null,
            'description' => null,
            'job_company' => null,
            'job_position' => null,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('attendees')
            ->join('users', 'attendees.user_id', '=', 'users.id')
            ->update([
                'attendees.first_name' => DB::raw('users.first_name'),
                'attendees.last_name' => DB::raw('users.last_name'),
                'attendees.avatar_url' => DB::raw('users.avatar_url'),
                'attendees.description' => DB::raw('users.description'),
                'attendees.job_company' => DB::raw('users.job_company'),
                'attendees.job_position' => DB::raw('users.job_position'),
            ]);

        DB::table('users')->update([
            'first_name' => null,
            'last_name' => null,
            'avatar_url' => null,
            'description' => null,
            'job_company' => null,
            'job_position' => null,
        ]);
    }
};
