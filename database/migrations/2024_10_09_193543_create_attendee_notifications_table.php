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
        Schema::create('attendee_notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['system', 'note_new', 'connection_new', 'connection_answer', 'claim_new', 'claim_answer', 'chat_new'])->default('system');
            $table->string('text');
            $table->string('link')->nullable();

            $table->uuid('attendee_id');
            $table->foreign('attendee_id')->references('id')->on('attendees')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendee_notifications');
    }
};
