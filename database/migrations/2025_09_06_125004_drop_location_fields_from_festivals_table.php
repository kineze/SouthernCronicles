<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('festivals', function (Blueprint $table) {
            // Drop all three columns
            $table->dropColumn(['location_place_id', 'location_lat', 'location_lng']);
        });
    }

    public function down(): void
    {
        Schema::table('festivals', function (Blueprint $table) {
            // Recreate columns if you ever roll back
            $table->string('location_place_id')->nullable();
            $table->decimal('location_lat', 10, 7)->nullable();
            $table->decimal('location_lng', 10, 7)->nullable();
        });
    }
};
