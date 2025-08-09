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

        // Backfill: position = row number by id asc
        DB::statement("
            UPDATE speaker_types st
            JOIN (
              SELECT id, ROW_NUMBER() OVER (ORDER BY id) AS rn
              FROM speaker_types
            ) x ON x.id = st.id
            SET st.position = x.rn
        ");
    }

    public function down(): void
    {
        Schema::table('speaker_types', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};
