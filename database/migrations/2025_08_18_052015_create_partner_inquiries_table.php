<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 120);
            $table->string('last_name', 120);
            $table->string('brand_name', 180);
            $table->string('email', 190)->index();
            $table->string('phone', 50);          // store normalized/E.164
            $table->string('country_iso2', 4)->nullable();
            $table->string('dial_code', 8)->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending','contacted','closed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_inquiries');
    }
};
