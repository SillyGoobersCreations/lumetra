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
        Schema::create('event_room_slots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('notes')->nullable();
            $table->enum('state', ['open', 'reserved', 'claim_open', 'claimed', 'unavailable'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_room_slots');
    }
};
