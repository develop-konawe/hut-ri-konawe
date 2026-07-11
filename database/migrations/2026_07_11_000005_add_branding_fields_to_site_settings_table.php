<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->string('header_title')->nullable()->after('registration_closed_message');
            $table->string('footer_title')->nullable()->after('header_title');
            $table->string('header_konawe_logo_path')->nullable()->after('footer_title');
            $table->string('header_hutri_logo_path')->nullable()->after('header_konawe_logo_path');
            $table->string('hero_logo_path')->nullable()->after('header_hutri_logo_path');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn([
                'header_title',
                'footer_title',
                'header_konawe_logo_path',
                'header_hutri_logo_path',
                'hero_logo_path',
            ]);
        });
    }
};
