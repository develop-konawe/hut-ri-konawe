<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->string('registration_status', 20)->default('open')->after('registration_enabled');
        });

        DB::table('site_settings')
            ->where('registration_enabled', false)
            ->update(['registration_status' => 'hidden']);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn('registration_status');
        });
    }
};
