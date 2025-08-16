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
        Schema::create('internships', function (Blueprint $t) {
            $t->id();
            $t->string('first_name');
            $t->string('last_name');
            $t->string('email');
            $t->string('phone')->nullable();              // full international
            $t->string('phone_country_iso2', 4)->nullable();
            $t->string('dial_code', 10)->nullable();
            $t->string('cv_path');                        // storage path
            $t->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); 
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
