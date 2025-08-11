<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->unsignedBigInteger('partner_type_id')->nullable()->after('title');

            // FK: when a partner type is deleted, keep the partner and set null
            $table->foreign('partner_type_id')
                  ->references('id')->on('partner_types')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropForeign(['partner_type_id']);
            $table->dropColumn('partner_type_id');
        });
    }
};
