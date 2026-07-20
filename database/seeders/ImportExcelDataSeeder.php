<?php

namespace Database\Seeders;

use App\Models\ActivityLocation;
use App\Models\Competition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ImportExcelDataSeeder extends Seeder
{
    public function run()
    {
        $jsonPath = base_path('parsed_excel.json');
        if (!file_exists($jsonPath)) {
            $this->command->error("parsed_excel.json not found!");
            return;
        }

        $data = json_decode(file_get_contents($jsonPath), true);
        $importedLomba = 0;
        $importedKegiatan = 0;

        foreach ($data as $row) {
            $kegiatan = trim($row['Kegiatan'] ?? '');
            if (empty($kegiatan) || $kegiatan === 'KEGIATAN' || is_numeric($kegiatan)) {
                continue;
            }

            $isLomba = preg_match('/lomba|bola|tarik tambang|gala asin|engrang|panjat pinang|voli|memancing|karaoke|stand up comedy|lagu solo/i', $kegiatan);

            // Parse Date
            $dateStr = $row['Hari_Tanggal'] ?? '';
            $parsedDate = '2026-08-01'; // Default
            if (is_numeric($dateStr)) {
                $parsedDate = date('Y-m-d', $dateStr / 1000);
            } elseif (is_string($dateStr)) {
                $parts = explode('-', $dateStr);
                $firstDate = trim($parts[0]);
                $dateObj = \DateTime::createFromFormat('d/m/Y', $firstDate);
                if ($dateObj) {
                    $parsedDate = $dateObj->format('Y-m-d');
                }
            }

            // Parse Time
            $waktuStr = $row['Waktu'] ?? '';
            $parsedTime = '08:00:00'; // Default
            if (is_string($waktuStr) && preg_match('/(\d{1,2})[\.:](\d{2})/', $waktuStr, $matches)) {
                $parsedTime = sprintf('%02d:%02d:00', $matches[1], $matches[2]);
            }
            $datetime = $parsedDate . ' ' . $parsedTime;

            $tempat = $row['Tempat'] ?? '-';
            $keterangan = $row['Keterangan'] ?? '';
            if (empty($keterangan)) {
                $keterangan = $row['Penanggung_Jawab'] ?? 'Tidak ada keterangan.';
            }

            if ($isLomba) {
                $category = 'umum';
                if (preg_match('/bola|lari|sepeda|voli|tambang|gala asin|engrang|panjat pinang|memancing|kelereng|karung/i', $kegiatan)) {
                    $category = 'olahraga';
                } elseif (preg_match('/puisi|lagu|karaoke|tari|pidato|stand up comedy|musik|karnaval/i', $kegiatan)) {
                    $category = 'seni';
                }

                Competition::create([
                    'name' => Str::limit($kegiatan, 200),
                    'slug' => Str::slug(Str::limit($kegiatan, 100)) . '-' . uniqid(),
                    'category' => $category,
                    'description' => $keterangan,
                    'starts_at' => $datetime,
                    'venue' => $tempat,
                    'quota' => null,
                    'is_open' => true,
                ]);
                $importedLomba++;
            } else {
                $type = 'umum';
                if (preg_match('/upacara|apel|paripurna|renungan|pengukuhan/i', $kegiatan)) {
                    $type = 'upacara';
                } elseif (preg_match('/seni|tari|festival/i', $kegiatan)) {
                    $type = 'seni';
                } elseif (preg_match('/olahraga/i', $kegiatan)) {
                    $type = 'olahraga';
                }

                ActivityLocation::create([
                    'name' => Str::limit($kegiatan, 200),
                    'type' => $type,
                    'address' => $tempat,
                    'latitude' => -3.8538400,
                    'longitude' => 122.0422200,
                    'activity_at' => $datetime,
                    'description' => $keterangan,
                    'is_registration_open' => false, // Default tertutup untuk kegiatan umum
                ]);
                $importedKegiatan++;
            }
        }

        $this->command->info("Berhasil mengimpor $importedLomba Lomba dan $importedKegiatan Kegiatan.");
    }
}
