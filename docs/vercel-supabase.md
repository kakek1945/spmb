# Vercel dan Supabase

Dokumen ini merangkum alur kerja repo `spmb` untuk Vercel dan Supabase.

## Vercel

1. Login CLI:

```bash
vercel login
```

2. Link folder lokal ke project:

```bash
vercel link
```

3. Lihat environment variables project:

```bash
vercel env ls
```

4. Tarik environment Vercel ke file lokal bila diperlukan:

```bash
vercel env pull .env.local
```

5. Deploy preview atau production:

```bash
vercel deploy
vercel deploy --prod
```

## Supabase

1. Inisialisasi konfigurasi lokal:

```bash
npx supabase init
```

2. Login ke Supabase CLI dengan access token dari dashboard:

```bash
npx supabase login
```

3. Link repo ini ke project Supabase cloud:

```bash
npx supabase link --project-ref <project-ref>
```

4. Ambil schema terbaru dari Supabase cloud:

```bash
npx supabase db pull
```

5. Dorong migration lokal ke Supabase cloud:

```bash
npx supabase db push
```

6. Jalankan Supabase lokal berbasis Docker:

```bash
npx supabase start
```

## Environment Laravel untuk Supabase Hosted

Gunakan variabel berikut saat aplikasi Laravel ini terhubung ke Supabase Postgres:

```env
DB_CONNECTION=pgsql
DB_HOST=aws-0-<region>.pooler.supabase.com
DB_PORT=6543
DB_DATABASE=postgres
DB_USERNAME=postgres.<project-ref>
DB_PASSWORD=<database-password>
DB_SSLMODE=require
```

Untuk runtime Vercel, queue sebaiknya memakai `sync` karena aplikasi berjalan sebagai PHP serverless function.
