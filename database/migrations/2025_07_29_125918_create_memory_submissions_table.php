<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('memory_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('given_name');
            $table->string('family_name')->nullable();
            $table->string('country')->nullable();
            $table->longText('submission');
            $table->boolean('is_copyright')->default(false);
            $table->string('copyright_holder')->nullable();
            $table->string('copyright_contact')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('memory_submissions');
    }
};
