<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_id')->constrained('careers')->cascadeOnDelete();
            $table->string('first_name', 120);
            $table->string('last_name', 120);
            $table->string('email', 190);
            $table->string('country_iso2', 2)->nullable();
            $table->string('dial_code', 8)->nullable();   // e.g. +94
            $table->string('phone', 32)->nullable();
            $table->string('cv_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('career_applications');
    }
};
