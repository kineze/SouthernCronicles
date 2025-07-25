<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('speakers', function (Blueprint $table) {
            $table->unsignedBigInteger('speaker_type_id')->nullable()->after('name');
            $table->text('description')->nullable()->after('linkedin');
            $table->boolean('show_on_home')->default(false)->after('description');

            $table->foreign('speaker_type_id')->references('id')->on('speaker_types')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('speakers', function (Blueprint $table) {
            $table->dropForeign(['speaker_type_id']);
            $table->dropColumn(['speaker_type_id', 'description', 'show_on_home']);
        });
    }
};
