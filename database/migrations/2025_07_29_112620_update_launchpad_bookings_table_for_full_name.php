<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('launchpad_bookings', function (Blueprint $table) {
            // Add new full_name column
            $table->string('full_name')->after('id');

            // Drop the old unused columns
            $table->dropColumn([
                'given_name',
                'family_name',
                'country',
                'submission_text',
                'is_copyright',
                'copyright_holder',
                'copyright_contact',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('launchpad_bookings', function (Blueprint $table) {
            // Recreate old columns if rolling back
            $table->string('given_name')->after('id');
            $table->string('family_name')->after('given_name');
            $table->string('country')->after('contact_number');
            $table->text('submission_text')->nullable();
            $table->boolean('is_copyright')->default(false);
            $table->string('copyright_holder')->nullable();
            $table->string('copyright_contact')->nullable();

            // Drop full_name
            $table->dropColumn('full_name');
        });
    }
};
