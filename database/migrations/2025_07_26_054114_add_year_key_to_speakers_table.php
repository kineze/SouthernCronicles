<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('speakers', function (Blueprint $table) {
            $table->string('year_key')->default('2025')->after('show_on_home');
        });
    }

    public function down(): void
    {
        Schema::table('speakers', function (Blueprint $table) {
            $table->dropColumn('year_key');
        });
    }
};
