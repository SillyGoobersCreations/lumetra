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
        Schema::create('attendees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('handle');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('avatar_url')->nullable();
            $table->boolean('confirmed')->default(true);
            $table->uuid('confirmation_key')->nullable();
            $table->text('description')->nullable();
            $table->string('job_company')->nullable();
            $table->string('job_position')->nullable();
            $table->boolean('active')->default(true);
            $table->enum('role', ['attendee', 'organizer'])->default('attendee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
};
