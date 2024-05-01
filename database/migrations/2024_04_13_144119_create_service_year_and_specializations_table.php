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
        Schema::create('service_year_and_specializations', function (Blueprint $table) {
            $table->id();
            $table->integer('serviceYear');
            $table->string('serviceSpecializationName');
            $table->timestamps();

            $table->unique(['serviceYear', 'serviceSpecializationName'], 'service_year_specialization_unique');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_year_and_specializations');

    }
};
