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
        Schema::create('event_room_slot_claims', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('state', ['pending', 'attendee_confirmed', 'attendee_declined', 'confirmed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_room_slot_claims');
    }
};
