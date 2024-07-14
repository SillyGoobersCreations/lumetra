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
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('state', ['draft', 'public', 'hidden'])->default('draft');
            $table->string('title');
            $table->string('organizer');
            $table->text('logo')->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('color_primary')->default('lumetra');
            $table->boolean('confirmation_required')->default(false);
            $table->boolean('confirmation_personalized')->default(false);
            $table->unsignedInteger('room_slot_max_pending')->nullable();
            $table->unsignedInteger('room_slot_max_claimed')->nullable();
            $table->boolean('room_slot_team_confirmation_required')->default(false);
            $table->unsignedInteger('attendees_max')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
