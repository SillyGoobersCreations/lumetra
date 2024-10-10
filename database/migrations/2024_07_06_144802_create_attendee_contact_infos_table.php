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
        Schema::create('attendee_contact_infos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['web', 'twitter', 'bluesky', 'facebook', 'linkedin', 'discord', 'mastodon', 'github', 'youtube', 'reddit']);
            $table->string('value');
            $table->enum('visibility', ['hidden', 'connections_only', 'public'])->default('hidden');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendee_contact_infos');
    }
};
