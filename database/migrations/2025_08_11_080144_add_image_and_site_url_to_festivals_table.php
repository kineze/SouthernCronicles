<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::table('festivals', function (Blueprint $table) {
            $table->string('image')->nullable()->after('location');
            $table->string('site_url')->nullable()->after('image');
        });
    }

    public function down(): void {
        Schema::table('festivals', function (Blueprint $table) {
            $table->dropColumn(['image', 'site_url']);
        });
    }
};
