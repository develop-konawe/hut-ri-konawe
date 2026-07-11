<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table): void {
            $table->id();
            $table->boolean('registration_enabled')->default(true);
            $table->string('registration_status', 20)->default('open');
            $table->text('registration_closed_message')->nullable();
            $table->string('header_title')->nullable();
            $table->string('footer_title')->nullable();
            $table->string('header_konawe_logo_path')->nullable();
            $table->string('header_hutri_logo_path')->nullable();
            $table->string('hero_logo_path')->nullable();
            $table->string('hero_background_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
