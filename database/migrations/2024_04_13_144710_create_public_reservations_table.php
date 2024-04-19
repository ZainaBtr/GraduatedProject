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
        Schema::create('public_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('normalUserID')->constrained('normal_users')->cascadeOnDelete();
            $table->foreignId('publicSessionID')->constrained('public_sessions')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_reservations');

    }
};
