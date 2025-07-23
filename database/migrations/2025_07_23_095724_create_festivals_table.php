<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('festivals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('location');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('festivals');
    }
};
