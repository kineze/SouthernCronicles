<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->date('event_date');
            $table->time('time_in');
            $table->time('time_out');
            $table->string('venue');
            $table->string('name');
            $table->string('event_type');
            $table->unsignedBigInteger('moderator_id')->nullable();
            $table->boolean('book_signing')->default(false);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
