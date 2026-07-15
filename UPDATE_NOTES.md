# Update Fitur Terbaru

Perubahan utama:

1. Admin dapat mengedit status absensi peserta tanpa validasi tunggu 7 jam.
2. Halaman peserta dipisah:
   - `/absensi/pagi`
   - `/absensi/sore`
   - `/absensi/data`
3. Appbar baru:
   - tombol garis tiga untuk membuka sidebar
   - nama user
   - posisi/divisi dalam struktur KKN
   - foto profil
   - tanggal dan jam realtime, bisa diklik untuk melihat detail
4. Sidebar baru:
   - peserta: Absen Pagi, Absen Sore, Data Absensi Saya
   - admin: Data Peserta Absensi, Laporan PDF & Excel, Profile
5. Profile sekarang mendukung upload/hapus foto profil dan ganti password.
6. Tambahan kolom database `photo_path` di tabel `users`.

Setelah copy overlay ke project Laravel, jalankan:

```bash
php artisan migrate
php artisan storage:link
npm run dev
```

Jika masih tahap awal dan database boleh direset:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
npm run dev
```

## Update terbaru

- Jam absen pagi peserta dibatasi pukul 05.00 - 11.00 WIB.
- Jam absen sore peserta dibatasi pukul 13.00 - 22.00 WIB.
- Peserta yang tidak mengisi absen pagi atau sore sampai batas waktu selesai tetap tercatat Alfa.
- Admin tetap bisa mengubah absensi kapan saja tanpa aturan jam absen dan tanpa menunggu 7 jam.
- Seeder sudah berisi akun admin dan seluruh peserta KKN.
- UI appbar, sidebar, login, form absensi, history, dashboard admin, dan laporan dirapikan menjadi gaya profesional yang lebih sederhana.


## Update terbaru

- Halaman admin memisahkan edit absensi menjadi dua tabel: **Tabel Absen Pagi** dan **Tabel Absen Sore**.
- Admin bisa mengubah absensi pagi maupun sore kapan saja, termasuk status **Pulang**, tanpa validasi jam peserta dan tanpa aturan minimal 7 jam.
- Appbar menampilkan tanggal dan jam. Saat diklik, muncul popup berisi kalender kecil, tanggal lengkap, bulan, tahun, dan jam berjalan.
