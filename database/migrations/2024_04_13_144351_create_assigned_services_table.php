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
        Schema::create('assigned_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advancedUserID')->constrained('advanced_users')->cascadeOnDelete();
            $table->foreignId('serviceID')->constrained('services')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['advancedUserID', 'serviceID'],'advanced_user_and_service_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_services');

    }
};
