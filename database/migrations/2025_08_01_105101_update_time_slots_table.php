<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('time_slots', function (Blueprint $table) {
            if (Schema::hasColumn('time_slots', 'title')) {
                $table->dropColumn('title');
            }

            $table->date('date')->nullable()->after('id');
            $table->boolean('is_active')->default(true)->after('end_time');
        });
    }

    public function down()
    {
        Schema::table('time_slots', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->dropColumn('date');
            $table->dropColumn('is_active');
        });
    }
};
