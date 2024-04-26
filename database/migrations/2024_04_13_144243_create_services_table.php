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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serviceManagerID')->constrained('services_managers');
            $table->foreignId('parentServiceID')->nullable()->constrained('services')->cascadeOnDelete();
            $table->foreignId('serviceYearAndSpecializationID')->constrained('service_year_and_specializations')->cascadeOnDelete();
            $table->string('serviceName');
            $table->text('serviceDescription')->nullable();
            $table->string('serviceType');
            $table->Integer('minimumNumberOfGroupMembers');
            $table->Integer('maximumNumberOfGroupMembers');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');

    }
};
