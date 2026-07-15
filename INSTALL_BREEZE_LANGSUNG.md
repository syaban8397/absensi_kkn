# Instalasi Absensi KKN — Breeze Sudah Langsung Dipasang

Panduan ini untuk paket `laravel_absensi_kkn_breeze_ready.zip`.

## Perbedaan dengan versi sebelumnya

Versi ini sudah berisi file hasil install Breeze, jadi kamu tidak perlu menjalankan:

```bash
php artisan breeze:install blade
```

File Breeze yang sudah disertakan:
- `routes/auth.php`
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- `app/Http/Requests/Auth/LoginRequest.php`
- `app/View/Components/AppLayout.php`
- `app/View/Components/GuestLayout.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/guest.blade.php`
- komponen input Blade
- halaman login
- Tailwind, Vite, Alpine setup

## Langkah Cepat

```bash
composer create-project laravel/laravel absensi-kkn
cd absensi-kkn

composer require barryvdh/laravel-dompdf
composer require maatwebsite/excel

npm install
```

Copy isi folder `laravel_absensi_kkn_breeze_ready` ke root project `absensi-kkn`.

Setelah itu setting `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_kkn
DB_USERNAME=root
DB_PASSWORD=
```

Buat database:

```sql
CREATE DATABASE absensi_kkn;
```

Jalankan:

```bash
php artisan config:clear
php artisan cache:clear
php artisan migrate:fresh --seed
php artisan storage:link
```

Jalankan aplikasi:

```bash
npm run dev
php artisan serve
```

Buka:

```text
http://127.0.0.1:8000/login
```

## Login

Admin:

```text
Username: admin
Password: AdminKKN#2026
```

Peserta:

```text
Username: rizky.syaban
Password: kkn2026
```

## Catatan

Kalau sebelumnya pernah gagal migrasi, jangan gunakan `php artisan migrate`.  
Gunakan:

```bash
php artisan migrate:fresh --seed
```
