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
        Schema::table('attendee_connections', function (Blueprint $table) {
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
        Schema::table('attendee_connections', function (Blueprint $table) {
            $table->dropForeign(['inviter_attendee_id']);
            $table->dropColumn('inviter_attendee_id');

            $table->dropForeign(['invitee_attendee_id']);
            $table->dropColumn('invitee_attendee_id');
        });
    }
};
