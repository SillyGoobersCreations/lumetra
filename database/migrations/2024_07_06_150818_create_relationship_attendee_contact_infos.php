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
        Schema::table('attendee_contact_infos', function (Blueprint $table) {
            $table->uuid('attendee_id');
            $table->foreign('attendee_id')->references('id')->on('attendees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendee_contact_infos', function (Blueprint $table) {
            $table->dropForeign(['attendee_id']);
            $table->dropColumn('attendee_id');
        });
    }
};
