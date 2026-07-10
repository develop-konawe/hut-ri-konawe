# Portal HUT RI Kabupaten Konawe

Project Laravel 12 untuk portal HUT RI dengan halaman pengunjung dan panel admin berdasarkan template yang disediakan.

## Fitur

- Beranda portal HUT RI.
- Login admin untuk proteksi panel.
- Berita olahraga dari API `https://berita.konawekab.go.id/api/v1/berita`.
- Pengumuman dari API `https://berita.konawekab.go.id/api/v1/pengumuman`.
- Jadwal lomba seni, olahraga, dan umum.
- Pendaftaran peserta lomba.
- Video kemerdekaan.
- Geotag lokasi kegiatan seni dan olahraga.
- Panel admin untuk dashboard, lomba, pendaftaran, dan lokasi.

## Arsitektur

- `app/Domain`: kontrak dan DTO domain, misalnya `NewsGateway` dan `NewsItem`.
- `app/Application`: use case aplikasi, misalnya `GetVisitorHomeData`, `ListNews`, dan `RegisterParticipant`.
- `app/Infrastructure`: adapter eksternal, misalnya `KonaweNewsApi`.
- `app/Http/Controllers`: controller web yang tipis dan memanggil use case.
- `resources/views`: Blade view untuk visitor dan admin.

## Konfigurasi API

Nilai default sudah ada di `.env.example` dan `config/hutri.php`.

```env
KONAWE_NEWS_API_BASE_URL=https://berita.konawekab.go.id/api/v1
KONAWE_NEWS_API_KEY=418595a9a453178dbdc3ea13af01789324f967e9cd60069e624de8b92003a613
KONAWE_NEWS_API_TIMEOUT=8
```

## Database MySQL

Konfigurasi lokal memakai MySQL Laragon:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hut_ri
DB_USERNAME=root
DB_PASSWORD=
```

Buat database bila belum ada:

```bash
mysql --host=127.0.0.1 --port=3306 --user=root -e "CREATE DATABASE IF NOT EXISTS hut_ri CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate:fresh --seed
php artisan serve --host=127.0.0.1 --port=8001
```

URL lokal yang sudah diuji:

- Visitor: `http://127.0.0.1:8001`
- Admin: `http://127.0.0.1:8001/admin`

## Akun Admin Default

Seeder membuat akun admin berikut:

```text
Email: admin@konawe81.id
Password: password
```

Ganti password sebelum deployment.

## Verifikasi

```bash
php artisan test
php artisan view:cache
php artisan route:list
```
