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
        Schema::create('normal_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userID')->constrained('users')->cascadeOnDelete();
            $table->foreignId('serviceYearAndSpecializationID')->constrained('service_year_and_specializations')->cascadeOnDelete();
            $table->bigInteger('examinationNumber')->unique();
            $table->string('studySituation');
            $table->boolean('isAccountCompleted')->default(0);
            $table->string('skills')->nullable();
            $table->date('birthDate')->nullable();
            $table->date('motherBirthDate')->nullable();
            $table->date('fatherBirthDate')->nullable();
            $table->integer('numberOfSisters')->nullable();
            $table->integer('numberOfBrothers')->nullable();
            $table->integer('numberOfMothersSister')->nullable();
            $table->integer('numberOfFathersSister')->nullable();
            $table->integer('numberOfMothersBrother')->nullable();
            $table->integer('numberOfFathersBrother')->nullable();
            $table->string('favoriteColor')->nullable();
            $table->string('favoriteSport')->nullable();
            $table->string('favoriteSeason')->nullable();
            $table->string('favoriteBookType')->nullable();
            $table->string('favoriteTravelCountry')->nullable();
            $table->string('favoriteFood')->nullable();
            $table->string('favoriteDesert')->nullable();
            $table->string('favoriteDrink')->nullable();
            $table->integer('baccalaureateMark')->nullable();
            $table->integer('ninthGradeMark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('normal_users');

    }
};
