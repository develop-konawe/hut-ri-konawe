<?php

namespace Database\Seeders;

use App\Models\ActivityLocation;
use App\Models\Competition;
use App\Models\IndependenceVideo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Konawe 81',
            'email' => 'admin@konawe81.id',
            'password' => Hash::make('password'),
        ]);

        Competition::query()->insert([
            [
                'name' => 'Turnamen Sepak Bola Bupati Cup',
                'slug' => 'turnamen-sepak-bola-bupati-cup',
                'category' => 'olahraga',
                'description' => 'Kompetisi sepak bola antar kecamatan dalam rangka HUT RI.',
                'starts_at' => '2026-08-10 15:30:00',
                'registration_deadline' => '2026-08-05 23:59:00',
                'venue' => 'Stadion Lakidende Unaaha',
                'quota' => 32,
                'is_open' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Festival Tari Lulo Merdeka',
                'slug' => 'festival-tari-lulo-merdeka',
                'category' => 'seni',
                'description' => 'Ajang kreasi seni budaya Tolaki untuk pelajar dan komunitas.',
                'starts_at' => '2026-08-15 19:30:00',
                'registration_deadline' => '2026-08-11 23:59:00',
                'venue' => 'Lapangan Kantor Bupati Konawe',
                'quota' => 50,
                'is_open' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lomba Gerak Jalan Indah',
                'slug' => 'lomba-gerak-jalan-indah',
                'category' => 'umum',
                'description' => 'Gerak jalan tingkat OPD, sekolah, dan masyarakat umum.',
                'starts_at' => '2026-08-13 07:00:00',
                'registration_deadline' => '2026-08-08 23:59:00',
                'venue' => 'Rute Kota Unaaha',
                'quota' => 80,
                'is_open' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        ActivityLocation::query()->insert([
            [
                'name' => 'Stadion Lakidende Unaaha',
                'type' => 'olahraga',
                'address' => 'Unaaha, Kabupaten Konawe',
                'latitude' => -3.8538400,
                'longitude' => 122.0422200,
                'activity_at' => '2026-08-10 15:30:00',
                'description' => 'Lokasi pertandingan sepak bola dan cabang olahraga lapangan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lapangan Kantor Bupati Konawe',
                'type' => 'seni',
                'address' => 'Kompleks Perkantoran Bupati Konawe',
                'latitude' => -3.8549500,
                'longitude' => 122.0415600,
                'activity_at' => '2026-08-15 19:30:00',
                'description' => 'Panggung utama seni budaya dan malam puncak kemerdekaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alun-alun Kota Unaaha',
                'type' => 'upacara',
                'address' => 'Pusat Kota Unaaha',
                'latitude' => -3.8527200,
                'longitude' => 122.0399900,
                'activity_at' => '2026-08-17 08:00:00',
                'description' => 'Titik pelaksanaan upacara dan rangkaian seremoni HUT RI.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        IndependenceVideo::query()->insert([
            [
                'title' => 'Semarak HUT RI di Konawe',
                'provider' => 'youtube',
                'embed_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail_url' => null,
                'description' => 'Dokumentasi rangkaian persiapan dan kegiatan kemerdekaan.',
                'is_featured' => true,
                'published_at' => '2026-08-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
