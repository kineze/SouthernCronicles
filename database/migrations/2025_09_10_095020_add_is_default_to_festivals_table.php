<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('festivals', function (Blueprint $table) {
            $table->boolean('is_default')->default(false)->after('position');
            $table->index('is_default');
        });
    }

    public function down(): void
    {
        Schema::table('festivals', function (Blueprint $table) {
            $table->dropIndex(['is_default']);
            $table->dropColumn('is_default');
        });
    }
    
};
