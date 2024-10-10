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
        Schema::table('event_room_slot_claims', function (Blueprint $table) {
            $table->uuid('event_room_slot_id');
            $table->foreign('event_room_slot_id')->references('id')->on('event_room_slots')->onDelete('cascade');

            $table->uuid('inviter_attendee_id');
            $table->foreign('inviter_attendee_id')->references('id')->on('attendees')->onDelete('cascade');

            $table->uuid('invitee_attendee_id');
            $table->foreign('invitee_attendee_id')->references('id')->on('attendees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_room_slot_claims', function (Blueprint $table) {
            $table->dropForeign(['event_room_slot_id']);
            $table->dropColumn('event_room_slot_id');

            $table->dropForeign(['inviter_attendee_id']);
            $table->dropColumn('inviter_attendee_id');

            $table->dropForeign(['invitee_attendee_id']);
            $table->dropColumn('invitee_attendee_id');
        });
    }
};
