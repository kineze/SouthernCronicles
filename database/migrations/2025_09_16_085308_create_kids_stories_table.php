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
        Schema::create('kids_stories', function (Blueprint $table) {
            $table->id();

            // Child / Guardian info
            $table->string('first_name');
            $table->unsignedTinyInteger('age');
            $table->string('location');
            $table->string('guardian_name');
            $table->string('guardian_email')->nullable();

            // Story meta
            $table->string('title');
            $table->json('genres')->nullable();
            $table->string('genre_other')->nullable();
            $table->text('main_characters');

            // Story content
            $table->longText('story_html')->nullable();
            $table->longText('story');

            // Optional drawing
            $table->string('drawing_path')->nullable();

            // ✅ No consent boolean in DB
            $table->string('guardian_signature');
            $table->date('consent_date');

            // Moderation
            $table->enum('status', ['pending','approved','rejected'])->default('pending')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kids_stories');
    }
};
