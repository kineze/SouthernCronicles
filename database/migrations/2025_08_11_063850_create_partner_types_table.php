<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('partner_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // "Partner type"
            $table->text('description')->nullable();// optional
            $table->unsignedInteger('position')->default(0); // for drag order
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_types');
    }
    
};
