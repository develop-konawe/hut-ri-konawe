<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('independence_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('media_url', 2048);
            $table->string('media_type', 20)->default('image');
            $table->text('description')->nullable();
            $table->string('link_url', 2048)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        if (! Schema::hasTable('independence_videos')) {
            return;
        }

        $now = now();

        DB::table('independence_videos')
            ->whereNotNull('thumbnail_url')
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->get()
            ->each(function (object $video, int $index) use ($now): void {
                $path = strtolower(parse_url($video->thumbnail_url, PHP_URL_PATH) ?? '');
                $mediaType = str_ends_with($path, '.mp4') || str_ends_with($path, '.webm') || str_ends_with($path, '.ogg')
                    ? 'video'
                    : 'image';

                DB::table('independence_banners')->insert([
                    'title' => $video->title,
                    'media_url' => $video->thumbnail_url,
                    'media_type' => $mediaType,
                    'description' => $video->description,
                    'is_active' => true,
                    'sort_order' => $index,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('independence_banners');
    }
};
