# SPMB Prapendaftaran 2026

Frontend-only demo aplikasi prapendaftaran SPMB berbasis Laravel Blade + Tailwind. Aplikasi ini mencakup landing page publik, form prapendaftaran, halaman sukses, login admin demo, dashboard admin, data pendaftar, kapasitas jalur, dan preview laporan.

## Jalankan dengan Docker

Prasyarat:

- Docker Desktop atau Docker Engine
- Docker Compose

Perintah:

```bash
docker compose up --build
```

Setelah container siap, buka:

- Publik: `http://localhost:8000`
- Form daftar: `http://localhost:8000/daftar`
- Login admin: `http://localhost:8000/admin/login`
- Dashboard admin: `http://localhost:8000/admin`

Untuk menghentikan container:

```bash
docker compose down
```

## Jalankan tanpa Docker

```bash
php artisan serve
npm.cmd run dev
```

## Catatan

- Setup Docker memakai SQLite di dalam container.
- File `.env.docker` dipakai khusus untuk environment Docker.
- Startup container akan membuat `APP_KEY`, menjalankan migrasi, membersihkan cache, lalu menyalakan aplikasi di port `8000`.
- Untuk deploy ke Vercel dengan `vercel-php`, pastikan `vercel.json` tersedia di root project. Runtime PHP komunitas menangani `composer install` sendiri.
- Di pengaturan project Vercel, pastikan Framework Preset diset ke `Other`. Jangan set Output Directory — biarkan kosong.
- Vite assets akan di-build saat deploy melalui `installCommand` di `vercel.json`.
- Pastikan semua environment variables (`APP_KEY`, `APP_URL`, `DB_*`) sudah diisi di Vercel Dashboard → Settings → Environment Variables.

