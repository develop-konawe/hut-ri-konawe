<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activity_locations', function (Blueprint $table) {
            $table->boolean('is_registration_open')->default(false)->after('description');
            $table->dateTime('registration_deadline')->nullable()->after('is_registration_open');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_locations', function (Blueprint $table) {
            $table->dropColumn(['is_registration_open', 'registration_deadline']);
        });
    }
};
