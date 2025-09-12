<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('festivals', function (Blueprint $table) {
            $table->unsignedInteger('position')
                  ->default(0)
                  ->index()
                  ->after('site_url'); // remove 'after' if not using MySQL
        });
    }

    public function down(): void
    {
        Schema::table('festivals', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};
