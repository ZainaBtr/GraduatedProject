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
        Schema::create('private_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groupID')->constrained('groups')->cascadeOnDelete();
            $table->foreignId('privateSessionID')->constrained('private_sessions')->cascadeOnDelete();
            $table->date('reservationDate');
            $table->time('reservationStartTime');
            $table->time('reservationEndTime');
            $table->boolean('privateReservationStatus')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_reservations');
    }
};
