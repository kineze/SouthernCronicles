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
        Schema::create('launchpad_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('given_name');
            $table->string('family_name');
            $table->string('email');
            $table->string('contact_number');
            $table->string('country');
            $table->text('submission_text');
            $table->boolean('is_copyright')->default(false);
            $table->string('copyright_holder')->nullable();
            $table->string('copyright_contact')->nullable();
            $table->enum('status', ['pending', 'approved', 'canceled'])->default('pending');
            $table->date('booking_date');
            $table->foreignId('time_slot_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('launchpad_bookings');
    }
};
