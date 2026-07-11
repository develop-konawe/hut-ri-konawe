<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Models\Registration;
use Illuminate\Database\Seeder;

class DummyRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $competitions = Competition::query()->orderBy('id')->get();

        if ($competitions->isEmpty()) {
            $competitions = collect([
                Competition::query()->firstOrCreate(
                    ['slug' => 'turnamen-sepak-bola-bupati-cup'],
                    [
                        'name' => 'Turnamen Sepak Bola Bupati Cup',
                        'category' => 'olahraga',
                        'description' => 'Kompetisi sepak bola antar kecamatan dalam rangka HUT RI.',
                        'starts_at' => '2026-08-10 15:30:00',
                        'registration_deadline' => '2026-08-05 23:59:00',
                        'venue' => 'Stadion Lakidende Unaaha',
                        'quota' => 32,
                        'is_open' => true,
                    ]
                ),
                Competition::query()->firstOrCreate(
                    ['slug' => 'festival-tari-lulo-merdeka'],
                    [
                        'name' => 'Festival Tari Lulo Merdeka',
                        'category' => 'seni',
                        'description' => 'Ajang kreasi seni budaya Tolaki untuk pelajar dan komunitas.',
                        'starts_at' => '2026-08-15 19:30:00',
                        'registration_deadline' => '2026-08-11 23:59:00',
                        'venue' => 'Lapangan Kantor Bupati Konawe',
                        'quota' => 50,
                        'is_open' => true,
                    ]
                ),
                Competition::query()->firstOrCreate(
                    ['slug' => 'lomba-gerak-jalan-indah'],
                    [
                        'name' => 'Lomba Gerak Jalan Indah',
                        'category' => 'umum',
                        'description' => 'Gerak jalan tingkat OPD, sekolah, dan masyarakat umum.',
                        'starts_at' => '2026-08-13 07:00:00',
                        'registration_deadline' => '2026-08-08 23:59:00',
                        'venue' => 'Rute Kota Unaaha',
                        'quota' => 80,
                        'is_open' => true,
                    ]
                ),
            ]);
        }

        $dummyRegistrations = [
            ['name' => 'Ahmad Fadli', 'phone' => '081245670001', 'email' => 'ahmad.fadli@example.test', 'institution' => 'Kecamatan Unaaha', 'status' => 'submitted'],
            ['name' => 'Nur Aisyah', 'phone' => '081245670002', 'email' => 'nur.aisyah@example.test', 'institution' => 'SMA Negeri 1 Unaaha', 'status' => 'verified'],
            ['name' => 'Rizal Pratama', 'phone' => '081245670003', 'email' => 'rizal.pratama@example.test', 'institution' => 'Komunitas Pemuda Konawe', 'status' => 'submitted'],
            ['name' => 'Sitti Rahma', 'phone' => '081245670004', 'email' => 'sitti.rahma@example.test', 'institution' => 'Sanggar Seni Tolaki', 'status' => 'verified'],
            ['name' => 'Muhammad Ilham', 'phone' => '081245670005', 'email' => 'm.ilham@example.test', 'institution' => 'Kecamatan Wawotobi', 'status' => 'submitted'],
            ['name' => 'Dewi Lestari', 'phone' => '081245670006', 'email' => 'dewi.lestari@example.test', 'institution' => 'SMK Negeri 2 Konawe', 'status' => 'submitted'],
            ['name' => 'Andi Saputra', 'phone' => '081245670007', 'email' => 'andi.saputra@example.test', 'institution' => 'Karang Taruna Unaaha', 'status' => 'rejected'],
            ['name' => 'Maya Anggraini', 'phone' => '081245670008', 'email' => 'maya.anggraini@example.test', 'institution' => 'Kecamatan Wonggeduku', 'status' => 'verified'],
            ['name' => 'La Ode Arman', 'phone' => '081245670009', 'email' => 'arman@example.test', 'institution' => 'Klub Sepak Bola Konawe Muda', 'status' => 'submitted'],
            ['name' => 'Fitriani', 'phone' => '081245670010', 'email' => 'fitriani@example.test', 'institution' => 'Sanggar Tari Mekongga', 'status' => 'submitted'],
            ['name' => 'Budi Santoso', 'phone' => '081245670011', 'email' => 'budi.santoso@example.test', 'institution' => 'Dinas Pendidikan Konawe', 'status' => 'verified'],
            ['name' => 'Indah Permatasari', 'phone' => '081245670012', 'email' => 'indah.permatasari@example.test', 'institution' => 'Kecamatan Anggaberi', 'status' => 'submitted'],
        ];

        foreach ($dummyRegistrations as $index => $data) {
            $competition = $competitions[$index % $competitions->count()];

            Registration::query()->updateOrCreate(
                [
                    'competition_id' => $competition->id,
                    'phone' => $data['phone'],
                ],
                [
                    'participant_name' => $data['name'],
                    'identity_number' => '74020'.str_pad((string) ($index + 1), 11, '0', STR_PAD_LEFT),
                    'email' => $data['email'],
                    'institution' => $data['institution'],
                    'address' => 'Kecamatan Unaaha, Kabupaten Konawe',
                    'status' => $data['status'],
                    'submitted_at' => now()->subDays(6 - ($index % 6))->subMinutes($index * 17),
                ]
            );
        }

        $this->command?->info('Dummy pendaftar lomba berhasil disiapkan: '.count($dummyRegistrations).' data.');
    }
}
