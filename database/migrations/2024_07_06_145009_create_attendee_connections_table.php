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
        Schema::create('attendee_connections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('state', ['pending', 'confirmed', 'declined'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('intro_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendee_connections');
    }
};
