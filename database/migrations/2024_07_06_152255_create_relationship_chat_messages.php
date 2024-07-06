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
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->uuid('sender_attendee_id');
            $table->foreign('sender_attendee_id')->references('id')->on('attendees')->onDelete('cascade');

            $table->uuid('receiver_attendee_id');
            $table->foreign('receiver_attendee_id')->references('id')->on('attendees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropForeign(['sender_attendee_id']);
            $table->dropColumn('sender_attendee_id');

            $table->dropForeign(['receiver_attendee_id']);
            $table->dropColumn('receiver_attendee_id');
        });
    }
};
