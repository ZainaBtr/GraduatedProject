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
        Schema::create('joining_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('normalUserID')->constrained('normal_users')->cascadeOnDelete();
            $table->foreignId('groupID')->constrained('groups')->cascadeOnDelete();
            $table->date('requestDate');
            $table->boolean('joinigRequestStatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joining_requests');

    }
};
