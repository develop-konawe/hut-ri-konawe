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
        Schema::create('independence_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('provider')->default('youtube');
            $table->string('embed_url');
            $table->string('thumbnail_url')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->date('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('independence_videos');
    }
};
