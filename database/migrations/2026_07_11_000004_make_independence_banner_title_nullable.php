<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE independence_banners MODIFY title VARCHAR(255) NULL');
    }

    public function down(): void
    {
        DB::table('independence_banners')
            ->whereNull('title')
            ->update(['title' => 'Banner Beranda']);

        DB::statement('ALTER TABLE independence_banners MODIFY title VARCHAR(255) NOT NULL');
    }
};
