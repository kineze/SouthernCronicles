<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galaxy_applications', function (Blueprint $t) {
            $t->id();

            $t->string('first_name');
            $t->string('last_name');
            $t->string('email');


            $t->string('phone')->nullable();
            $t->string('phone_country_iso2', 4)->nullable();
            $t->string('dial_code', 10)->nullable();

            $t->text('description')->nullable();

            $t->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galaxy_applications');
    }
};
