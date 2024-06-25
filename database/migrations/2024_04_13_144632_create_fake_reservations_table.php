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
        Schema::create('fake_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('privateSessionID')->constrained('private_sessions')->cascadeOnDelete();
            $table->time('reservationStartTime');
            $table->time('reservationEndTime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fake_reservations');
    }
};
