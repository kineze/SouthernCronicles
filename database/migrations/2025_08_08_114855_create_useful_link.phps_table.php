<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('useful_links', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');          // keep as string; validate URL in controller
            $table->string('image')->nullable(); // stored path like links/abc.jpg
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('useful_links');
    }

};
