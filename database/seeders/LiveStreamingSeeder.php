<?php

namespace Database\Seeders;

use App\Models\LiveStreaming;
use Illuminate\Database\Seeder;

class LiveStreamingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LiveStreaming::query()->create([
            'title' => 'Pembukaan Lomba Kemerdekaan RI ke-81 Konawe',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Placeholder URL
            'is_active' => true,
        ]);

        LiveStreaming::query()->create([
            'title' => 'Final Lomba Tarik Tambang Antar Instansi',
            'youtube_url' => 'https://www.youtube.com/watch?v=y6120QOlsfU', // Placeholder URL
            'is_active' => true,
        ]);

        LiveStreaming::query()->create([
            'title' => 'Malam Puncak & Pesta Rakyat HUT RI',
            'youtube_url' => 'https://www.youtube.com/watch?v=tPEE9ZwTmy0', // Placeholder URL
            'is_active' => false,
        ]);
    }
}
