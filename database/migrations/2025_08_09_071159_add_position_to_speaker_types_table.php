<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('speaker_types', function (Blueprint $table) {
            $table->unsignedInteger('position')->after('name')->nullable()->index();
        });

        DB::statement("SET @row_number := 0");
        DB::statement("
            UPDATE speaker_types
            SET position = (@row_number := @row_number + 1)
            ORDER BY id
        ");
    }


    public function down(): void
    {
        Schema::table('speaker_types', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};
