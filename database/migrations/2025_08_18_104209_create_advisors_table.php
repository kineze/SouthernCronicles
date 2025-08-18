<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('advisors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('advisor_type_id')
                ->constrained('advisor_types')
                ->cascadeOnDelete();

            $table->unsignedInteger('position')->default(0);

            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // storage path
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->boolean('show_on_home')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advisors');
    }
};
