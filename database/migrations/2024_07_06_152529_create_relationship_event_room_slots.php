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
        Schema::table('event_room_slots', function (Blueprint $table) {
            $table->uuid('event_room_id');
            $table->foreign('event_room_id')->references('id')->on('event_rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_room_slots', function (Blueprint $table) {
            $table->dropForeign(['event_room_id']);
            $table->dropColumn('event_room_id');
        });
    }
};
