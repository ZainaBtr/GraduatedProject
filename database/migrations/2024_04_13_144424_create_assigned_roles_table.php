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
        Schema::create('assigned_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignedServiceID')->constrained('assigned_services')->cascadeOnDelete();
            $table->foreignId('roleID')->constrained('roles')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_roles');

    }
};
