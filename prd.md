# PRD — Aplikasi Web Landing Page SPMB Prapendaftaran Murid Baru

## 1. Ringkasan Produk

Aplikasi ini adalah sistem web sederhana untuk mendata calon murid baru pada tahap **prapendaftaran SPMB**. Sistem berfungsi sebagai landing page publik yang memungkinkan pendaftar mengisi data diri dan memilih jalur pendaftaran, yaitu:

1. **Domisili**
2. **Afirmasi**
3. **Prestasi**

Admin dapat melihat data pendaftar, mengatur kapasitas setiap jalur, memantau jumlah pendaftar per jalur, dan membuat laporan. Sistem ini **bukan sistem seleksi akhir**, melainkan alat bantu pendataan awal untuk mengetahui minat dan sebaran calon siswa berdasarkan jalur pendaftaran.

---

## 2. Tujuan Produk

### 2.1 Tujuan Utama

Membangun aplikasi SPMB prapendaftaran yang:

* Simple dan mudah digunakan oleh calon pendaftar.
* Cepat diakses dari perangkat mobile maupun desktop.
* Responsive untuk berbagai ukuran layar.
* Memudahkan sekolah/admin mendata calon siswa berdasarkan jalur pendaftaran.
* Memungkinkan admin menentukan kapasitas masing-masing jalur.
* Menyediakan laporan jumlah pendaftar berdasarkan jalur, status, dan periode pendaftaran.

### 2.2 Manfaat

Untuk pendaftar:

* Bisa mendaftar secara mandiri melalui landing page.
* Bisa memilih jalur pendaftaran sesuai kondisi masing-masing.
* Mendapat bukti atau nomor prapendaftaran setelah mengirim data.

Untuk admin:

* Bisa melihat semua data pendaftar dalam dashboard.
* Bisa memantau kuota/kapasitas tiap jalur.
* Bisa mengetahui jumlah pendaftar jalur Domisili, Afirmasi, dan Prestasi.
* Bisa mengekspor atau mencetak laporan.

---

## 3. Target Pengguna

### 3.1 Pendaftar / Calon Murid / Orang Tua

Pengguna publik yang mengakses landing page untuk melakukan prapendaftaran.

Kebutuhan utama:

* Informasi singkat tentang SPMB.
* Formulir pendaftaran yang mudah dipahami.
* Pilihan jalur pendaftaran yang jelas.
* Proses submit cepat.
* Bukti pendaftaran sederhana.

### 3.2 Admin Sekolah

Pengguna internal yang mengelola data pendaftar dan laporan.

Kebutuhan utama:

* Login aman ke dashboard.
* Melihat statistik pendaftaran.
* Mengelola kapasitas jalur.
* Melihat, mencari, memfilter, dan mengunduh data pendaftar.
* Membuat laporan rekapitulasi.

---

## 4. Ruang Lingkup Produk

### 4.1 In Scope

Fitur yang akan dibuat:

1. Landing page SPMB.
2. Form prapendaftaran calon murid.
3. Pilihan jalur pendaftaran: Domisili, Afirmasi, Prestasi.
4. Validasi form pendaftaran.
5. Nomor prapendaftaran otomatis.
6. Halaman sukses setelah pendaftaran.
7. Login admin.
8. Dashboard admin.
9. Statistik jumlah pendaftar per jalur.
10. Pengaturan kapasitas per jalur.
11. Daftar data pendaftar.
12. Filter dan pencarian data pendaftar.
13. Detail data pendaftar.
14. Update status pendaftar prapendaftaran.
15. Export laporan ke Excel/CSV.
16. Cetak laporan sederhana.

### 4.2 Out of Scope

Fitur yang tidak termasuk tahap awal:

1. Sistem seleksi otomatis.
2. Perangkingan nilai otomatis.
3. Integrasi Dapodik.
4. Pembayaran online.
5. Verifikasi dokumen digital kompleks.
6. Upload dokumen besar/multi-file kompleks.
7. Notifikasi WhatsApp/SMS otomatis.
8. Multi sekolah/multi tenant.
9. Sistem akun untuk pendaftar.
10. Pengumuman hasil akhir seleksi.

---

## 5. Platform dan Teknologi

### 5.1 Framework Utama

* Backend: **Laravel**
* Frontend: Blade Laravel + Tailwind CSS atau Bootstrap ringan
* Database: MySQL/MariaDB
* Auth Admin: Laravel Breeze atau auth sederhana berbasis Laravel
* Export laporan: Laravel Excel atau export CSV native
* Deployment target: shared hosting, VPS, atau cloud hosting ringan

### 5.2 Prinsip Teknologi

* Menggunakan framework ringan dan familiar.
* Tidak menggunakan frontend SPA berat pada versi awal.
* Server-side rendering menggunakan Blade agar cepat dan SEO-friendly.
* Asset frontend diminimalkan agar landing page ringan.
* Desain mobile-first.

---

## 6. Struktur Peran Pengguna

### 6.1 Guest / Pendaftar

Akses:

* Melihat landing page.
* Mengisi form prapendaftaran.
* Mengirim data pendaftaran.
* Melihat halaman berhasil daftar.

Tidak dapat:

* Login ke dashboard.
* Melihat data pendaftar lain.
* Mengubah data setelah submit, kecuali fitur edit publik ditambahkan di versi berikutnya.

### 6.2 Admin

Akses:

* Login/logout dashboard.
* Melihat ringkasan statistik.
* Melihat semua data pendaftar.
* Melihat detail pendaftar.
* Mengubah status prapendaftaran.
* Mengatur kapasitas jalur.
* Mengekspor laporan.

---

## 7. Alur Pengguna

### 7.1 Alur Pendaftar

1. Pendaftar membuka landing page SPMB.
2. Pendaftar membaca informasi singkat.
3. Pendaftar klik tombol **Daftar Sekarang**.
4. Sistem menampilkan form prapendaftaran.
5. Pendaftar mengisi data diri.
6. Pendaftar memilih salah satu jalur:

   * Domisili
   * Afirmasi
   * Prestasi
7. Sistem melakukan validasi data.
8. Sistem mengecek kapasitas jalur.
9. Jika kapasitas masih tersedia, data disimpan.
10. Sistem membuat nomor prapendaftaran otomatis.
11. Pendaftar diarahkan ke halaman sukses.
12. Pendaftar dapat menyimpan/mencetak bukti prapendaftaran sederhana.

### 7.2 Alur Admin

1. Admin membuka halaman login.
2. Admin login menggunakan email dan password.
3. Admin masuk ke dashboard.
4. Admin melihat statistik total pendaftar.
5. Admin melihat rekap pendaftar per jalur.
6. Admin melihat kapasitas dan sisa kuota tiap jalur.
7. Admin membuka daftar pendaftar.
8. Admin dapat melakukan pencarian/filter.
9. Admin dapat melihat detail pendaftar.
10. Admin dapat mengubah status pendaftar.
11. Admin dapat mengunduh laporan.

---

## 8. Fitur Publik / Landing Page

### 8.1 Hero Section

Konten:

* Judul: “SPMB Prapendaftaran Murid Baru”
* Subjudul singkat tentang tujuan sistem.
* Tombol utama: “Daftar Sekarang”
* Tombol sekunder: “Lihat Informasi Jalur”

### 8.2 Informasi Jalur Pendaftaran

Menampilkan 3 kartu:

#### Domisili

Untuk calon murid berdasarkan wilayah tempat tinggal atau zona domisili.

#### Afirmasi

Untuk calon murid yang memenuhi kriteria afirmasi sesuai ketentuan sekolah/pemerintah.

#### Prestasi

Untuk calon murid yang memiliki prestasi akademik atau non-akademik.

### 8.3 Informasi Kapasitas Jalur

Landing page dapat menampilkan ringkasan kapasitas secara sederhana:

* Domisili: kapasitas, jumlah pendaftar, sisa kuota.
* Afirmasi: kapasitas, jumlah pendaftar, sisa kuota.
* Prestasi: kapasitas, jumlah pendaftar, sisa kuota.

Catatan: tampilan kapasitas publik dapat dibuat opsional dari dashboard admin.

### 8.4 Form Prapendaftaran

Field minimal:

* Nama lengkap calon murid
* NISN, jika ada
* NIK, opsional sesuai kebutuhan sekolah
* Tempat lahir
* Tanggal lahir
* Jenis kelamin
* Alamat domisili
* Asal sekolah
* Nama orang tua/wali
* Nomor HP orang tua/wali
* Email, opsional
* Jalur pendaftaran
* Catatan tambahan, opsional

Field khusus per jalur:

#### Domisili

* Alamat domisili lengkap
* Kecamatan/kelurahan/desa
* Jarak rumah ke sekolah, opsional

#### Afirmasi

* Jenis afirmasi
* Nomor kartu/program bantuan, opsional
* Keterangan pendukung, opsional

#### Prestasi

* Jenis prestasi
* Tingkat prestasi
* Nama lomba/kompetisi
* Tahun prestasi

### 8.5 Validasi Form

Validasi minimal:

* Nama wajib diisi.
* Tanggal lahir wajib diisi.
* Jenis kelamin wajib dipilih.
* Alamat wajib diisi.
* Asal sekolah wajib diisi.
* Nama orang tua/wali wajib diisi.
* Nomor HP wajib diisi.
* Jalur pendaftaran wajib dipilih.
* Nomor HP harus format angka yang valid.
* Jalur tidak dapat dipilih jika kapasitas sudah penuh, jika aturan ini diaktifkan.

### 8.6 Halaman Sukses Pendaftaran

Menampilkan:

* Pesan berhasil.
* Nomor prapendaftaran.
* Nama pendaftar.
* Jalur pendaftaran.
* Tanggal pendaftaran.
* Tombol cetak/simpan bukti.

---

## 9. Fitur Dashboard Admin

### 9.1 Login Admin

Fitur:

* Login email dan password.
* Logout.
* Middleware auth untuk semua halaman admin.

### 9.2 Dashboard Ringkasan

Menampilkan kartu statistik:

* Total pendaftar.
* Total pendaftar jalur Domisili.
* Total pendaftar jalur Afirmasi.
* Total pendaftar jalur Prestasi.
* Kapasitas total.
* Sisa kapasitas total.

Menampilkan chart sederhana:

* Diagram batang jumlah pendaftar per jalur.
* Diagram persentase keterisian kapasitas per jalur.

### 9.3 Manajemen Kapasitas Jalur

Admin dapat mengatur:

* Kapasitas jalur Domisili.
* Kapasitas jalur Afirmasi.
* Kapasitas jalur Prestasi.
* Status jalur: aktif/nonaktif.
* Apakah jalur tetap menerima pendaftar saat kapasitas penuh.

Aturan default:

* Jika kapasitas jalur sudah penuh, sistem menolak pendaftaran pada jalur tersebut.
* Admin dapat mengubah kapasitas kapan saja.
* Jika kapasitas dikurangi di bawah jumlah pendaftar existing, sistem memberi peringatan tetapi tidak menghapus data.

### 9.4 Data Pendaftar

Tabel menampilkan:

* Nomor prapendaftaran
* Nama calon murid
* Jalur pendaftaran
* Asal sekolah
* Nama orang tua/wali
* Nomor HP
* Status
* Tanggal daftar
* Aksi detail

Fitur tabel:

* Search nama/nomor prapendaftaran/NISN.
* Filter jalur.
* Filter status.
* Filter tanggal daftar.
* Pagination.
* Sorting tanggal terbaru.

### 9.5 Detail Pendaftar

Menampilkan seluruh informasi pendaftar:

* Data calon murid.
* Data orang tua/wali.
* Jalur pendaftaran.
* Informasi tambahan berdasarkan jalur.
* Status prapendaftaran.
* Catatan admin.

Admin dapat:

* Mengubah status.
* Menambahkan catatan.
* Mencetak detail pendaftar.

### 9.6 Status Prapendaftaran

Status awal yang disarankan:

1. **Baru** — data baru masuk.
2. **Dicek** — data sedang diperiksa admin.
3. **Perlu Perbaikan** — data perlu dilengkapi oleh pendaftar secara manual/offline.
4. **Valid Prapendaftaran** — data dianggap valid untuk proses berikutnya.
5. **Ditolak Prapendaftaran** — data tidak memenuhi syarat prapendaftaran.

Catatan: status ini hanya untuk proses administrasi awal, bukan hasil seleksi final.

### 9.7 Laporan

Admin dapat membuat laporan berdasarkan:

* Semua pendaftar.
* Jalur Domisili.
* Jalur Afirmasi.
* Jalur Prestasi.
* Status pendaftar.
* Rentang tanggal pendaftaran.

Output laporan:

* Tabel di dashboard.
* Export CSV.
* Export Excel, opsional.
* Print/PDF sederhana, opsional.

Isi laporan minimal:

* Nomor prapendaftaran
* Nama calon murid
* Jalur pendaftaran
* Asal sekolah
* Nama orang tua/wali
* Nomor HP
* Status
* Tanggal daftar

---

## 10. Aturan Bisnis

### 10.1 Jalur Pendaftaran

* Setiap pendaftar hanya dapat memilih satu jalur.
* Jalur yang tersedia: Domisili, Afirmasi, Prestasi.
* Admin dapat mengaktifkan/nonaktifkan jalur.
* Jika jalur nonaktif, pendaftar tidak dapat memilih jalur tersebut.

### 10.2 Kapasitas Jalur

* Setiap jalur memiliki kapasitas yang ditentukan admin.
* Sistem menghitung jumlah pendaftar aktif pada setiap jalur.
* Sisa kuota = kapasitas jalur - jumlah pendaftar pada jalur tersebut.
* Jika kapasitas penuh, sistem dapat menutup jalur tersebut secara otomatis.
* Data yang sudah masuk tetap tersimpan meskipun kapasitas kemudian diubah.

### 10.3 Nomor Prapendaftaran

Format nomor disarankan:

```text
SPMB-{TAHUN}-{JALUR}-{NOMOR_URUT}
```

Contoh:

```text
SPMB-2026-DOM-0001
SPMB-2026-AFR-0001
SPMB-2026-PRS-0001
```

Kode jalur:

* DOM = Domisili
* AFR = Afirmasi
* PRS = Prestasi

### 10.4 Duplikasi Data

Sistem dapat mencegah duplikasi berdasarkan:

* NISN, jika diisi.
* NIK, jika digunakan.
* Kombinasi nama calon murid + tanggal lahir + nomor HP orang tua.

Pada versi awal, validasi duplikasi dapat berupa peringatan untuk admin, bukan blokir penuh.

### 10.5 Status Data

* Semua pendaftaran baru otomatis berstatus **Baru**.
* Admin dapat mengubah status sesuai proses verifikasi awal.
* Perubahan status disimpan dengan waktu update.

---

## 11. Kebutuhan Non-Fungsional

### 11.1 Performance

Target:

* Landing page ringan dan cepat dimuat.
* Tidak menggunakan bundle JavaScript besar.
* Query dashboard menggunakan pagination.
* Index database pada kolom pencarian dan filter utama.

### 11.2 Responsiveness

Aplikasi harus nyaman digunakan pada:

* Mobile phone.
* Tablet.
* Desktop.

Prioritas desain:

* Mobile-first.
* Form mudah diisi di layar kecil.
* Tombol besar dan jelas.
* Layout dashboard tetap terbaca di layar laptop.

### 11.3 Security

Minimal security:

* CSRF protection Laravel.
* Validasi request server-side.
* Password admin di-hash.
* Middleware auth untuk dashboard.
* Rate limit pada submit form untuk mengurangi spam.
* Sanitasi output pada Blade.
* Tidak menampilkan data sensitif ke publik.

### 11.4 Reliability

* Data pendaftaran harus tersimpan konsisten.
* Submit form harus menggunakan transaksi database jika diperlukan.
* Error validasi harus jelas untuk user.
* Jika terjadi error server, user mendapat pesan umum tanpa detail teknis.

### 11.5 Maintainability

* Struktur kode mengikuti standar Laravel.
* Controller dipisah antara public dan admin.
* Business logic kapasitas sebaiknya ditempatkan di service class.
* Nama migration, model, dan route dibuat jelas.

---

## 12. Struktur Database Awal

### 12.1 Tabel `users`

Untuk akun admin.

Field utama:

* id
* name
* email
* password
* created_at
* updated_at

### 12.2 Tabel `registration_paths`

Untuk data jalur pendaftaran dan kapasitas.

Field:

* id
* code
* name
* description
* capacity
* is_active
* close_when_full
* created_at
* updated_at

Contoh data awal:

| code | name     | capacity | is_active |
| ---- | -------- | -------: | --------- |
| DOM  | Domisili |      100 | true      |
| AFR  | Afirmasi |       30 | true      |
| PRS  | Prestasi |       20 | true      |

### 12.3 Tabel `student_registrations`

Untuk data pendaftar.

Field:

* id
* registration_number
* registration_path_id
* full_name
* nisn
* nik
* birth_place
* birth_date
* gender
* address
* village
* district
* previous_school
* parent_name
* parent_phone
* email
* special_data JSON, untuk data khusus jalur
* status
* admin_note
* submitted_at
* created_at
* updated_at

### 12.4 Tabel Opsional `registration_status_logs`

Untuk riwayat perubahan status.

Field:

* id
* student_registration_id
* old_status
* new_status
* note
* changed_by
* created_at

---

## 13. Struktur Route Laravel

### 13.1 Public Routes

```php
GET  /                      Landing page
GET  /daftar                Form pendaftaran
POST /daftar                Submit pendaftaran
GET  /daftar/sukses/{id}    Halaman sukses pendaftaran
```

### 13.2 Admin Routes

```php
GET  /admin/login                         Login admin
POST /admin/login                         Proses login
POST /admin/logout                        Logout

GET  /admin                               Dashboard
GET  /admin/pendaftar                     Daftar pendaftar
GET  /admin/pendaftar/{id}                Detail pendaftar
PATCH /admin/pendaftar/{id}/status        Update status pendaftar

GET  /admin/kapasitas                     Pengaturan kapasitas
PATCH /admin/kapasitas/{id}               Update kapasitas jalur

GET  /admin/laporan                       Halaman laporan
GET  /admin/laporan/export                Export laporan CSV/Excel
GET  /admin/laporan/print                 Print laporan
```

---

## 14. Struktur Halaman

### 14.1 Public

1. `/`

   * Landing page.
   * Hero section.
   * Info jalur.
   * Statistik kapasitas opsional.
   * CTA daftar.

2. `/daftar`

   * Form prapendaftaran.
   * Pilihan jalur.
   * Input data calon murid.
   * Input data orang tua/wali.

3. `/daftar/sukses/{id}`

   * Bukti prapendaftaran.
   * Nomor prapendaftaran.
   * Ringkasan data.

### 14.2 Admin

1. `/admin`

   * Dashboard statistik.
   * Grafik sederhana.
   * Ringkasan kapasitas.

2. `/admin/pendaftar`

   * Tabel data pendaftar.
   * Search/filter.
   * Pagination.

3. `/admin/pendaftar/{id}`

   * Detail data.
   * Update status.
   * Catatan admin.

4. `/admin/kapasitas`

   * Form kapasitas tiap jalur.
   * Toggle aktif/nonaktif jalur.

5. `/admin/laporan`

   * Filter laporan.
   * Preview laporan.
   * Export laporan.

---

## 15. Desain UI/UX

### 15.1 Prinsip Desain

* Bersih, sederhana, dan informatif.
* Warna utama dapat menyesuaikan identitas sekolah.
* CTA jelas: “Daftar Sekarang”.
* Form tidak terlalu panjang secara visual.
* Gunakan section dan grouping field agar mudah dipahami.
* Dashboard admin fokus pada data dan angka penting.

### 15.2 Komponen UI Publik

* Navbar sederhana.
* Hero section.
* Card jalur pendaftaran.
* Badge kapasitas/sisa kuota.
* Form input.
* Alert validasi.
* Footer sederhana.

### 15.3 Komponen UI Admin

* Sidebar atau topbar admin.
* Statistik card.
* Tabel responsive.
* Filter form.
* Badge status.
* Button export.
* Modal konfirmasi sederhana, opsional.

---

## 16. MVP

### 16.1 MVP Wajib

Fitur yang harus ada pada rilis pertama:

1. Landing page.
2. Form prapendaftaran.
3. Pilihan jalur Domisili, Afirmasi, Prestasi.
4. Simpan data pendaftar.
5. Nomor prapendaftaran otomatis.
6. Login admin.
7. Dashboard statistik.
8. Tabel data pendaftar.
9. Pengaturan kapasitas jalur.
10. Export CSV laporan.

### 16.2 MVP Opsional

Fitur yang bisa ditambahkan setelah MVP:

1. Export Excel.
2. Cetak bukti pendaftaran.
3. Upload dokumen pendukung.
4. Riwayat perubahan status.
5. Grafik dashboard.
6. Public tracking nomor pendaftaran.
7. Notifikasi email/WhatsApp.

---

## 17. Acceptance Criteria

### 17.1 Landing Page

* User dapat membuka halaman utama tanpa login.
* User dapat melihat informasi jalur pendaftaran.
* User dapat klik tombol daftar dan diarahkan ke form.
* Halaman tampil baik di mobile dan desktop.

### 17.2 Form Pendaftaran

* User dapat mengisi data wajib.
* User wajib memilih salah satu jalur.
* Sistem menampilkan error jika field wajib kosong.
* Sistem menyimpan data valid ke database.
* Sistem membuat nomor prapendaftaran otomatis.
* Sistem menampilkan halaman sukses setelah submit.

### 17.3 Kapasitas Jalur

* Admin dapat mengatur kapasitas setiap jalur.
* Sistem menghitung jumlah pendaftar per jalur.
* Sistem menghitung sisa kuota per jalur.
* Jika jalur penuh dan opsi close_when_full aktif, user tidak dapat memilih jalur tersebut.

### 17.4 Dashboard Admin

* Admin wajib login untuk masuk dashboard.
* Admin dapat melihat total pendaftar.
* Admin dapat melihat jumlah pendaftar per jalur.
* Admin dapat melihat kapasitas dan sisa kuota.
* Admin dapat membuka daftar pendaftar.

### 17.5 Laporan

* Admin dapat memfilter laporan berdasarkan jalur.
* Admin dapat memfilter laporan berdasarkan status.
* Admin dapat memfilter laporan berdasarkan tanggal.
* Admin dapat export laporan ke CSV.

---

## 18. Rencana Implementasi

### Phase 1 — Setup Project

Estimasi: 1 hari

Task:

* Setup Laravel project.
* Setup database.
* Setup environment `.env`.
* Install auth admin sederhana.
* Setup layout Blade dan asset CSS.

Output:

* Project Laravel siap dikembangkan.
* Admin bisa login.

### Phase 2 — Database dan Model

Estimasi: 1 hari

Task:

* Buat migration `registration_paths`.
* Buat migration `student_registrations`.
* Buat seeder jalur pendaftaran.
* Buat model dan relasi.

Output:

* Struktur database siap.
* Data jalur default tersedia.

### Phase 3 — Landing Page dan Form Pendaftaran

Estimasi: 2 hari

Task:

* Buat landing page.
* Buat halaman form daftar.
* Buat validasi request.
* Buat logic cek kapasitas.
* Buat nomor prapendaftaran otomatis.
* Buat halaman sukses.

Output:

* Pendaftar bisa melakukan prapendaftaran.

### Phase 4 — Dashboard Admin

Estimasi: 2 hari

Task:

* Buat dashboard statistik.
* Buat tabel pendaftar.
* Buat detail pendaftar.
* Buat update status.
* Buat filter dan search.

Output:

* Admin bisa mengelola data pendaftar.

### Phase 5 — Kapasitas dan Laporan

Estimasi: 1–2 hari

Task:

* Buat halaman pengaturan kapasitas.
* Buat update kapasitas jalur.
* Buat halaman laporan.
* Buat export CSV.
* Buat print view sederhana.

Output:

* Admin bisa mengatur kapasitas dan membuat laporan.

### Phase 6 — Testing dan Deployment

Estimasi: 1–2 hari

Task:

* Test form pendaftaran.
* Test validasi kapasitas.
* Test login admin.
* Test filter laporan.
* Test responsive mobile.
* Deploy ke hosting.

Output:

* Aplikasi siap digunakan untuk prapendaftaran.

---

## 19. Estimasi Timeline

Estimasi total MVP: **8–10 hari kerja**

| Phase                  | Estimasi |
| ---------------------- | -------: |
| Setup Project          |   1 hari |
| Database dan Model     |   1 hari |
| Landing Page dan Form  |   2 hari |
| Dashboard Admin        |   2 hari |
| Kapasitas dan Laporan  | 1–2 hari |
| Testing dan Deployment | 1–2 hari |

---

## 20. Risiko dan Mitigasi

### Risiko 1: Data pendaftar ganda

Mitigasi:

* Tambahkan validasi NISN/NIK.
* Beri peringatan pada admin jika data mirip.

### Risiko 2: Jalur penuh tapi masih ada pendaftar masuk

Mitigasi:

* Cek kapasitas saat submit.
* Gunakan transaksi database bila diperlukan.
* Tambahkan opsi close_when_full.

### Risiko 3: Pendaftar kesulitan mengisi form

Mitigasi:

* Buat form sederhana.
* Gunakan label jelas.
* Gunakan placeholder dan bantuan singkat.

### Risiko 4: Admin membutuhkan laporan cepat

Mitigasi:

* Sediakan export CSV di MVP.
* Tambahkan Excel/PDF di versi berikutnya.

### Risiko 5: Hosting terbatas

Mitigasi:

* Gunakan Blade server-side rendering.
* Hindari frontend berat.
* Optimalkan query dan pagination.

---

## 21. Rekomendasi Struktur Folder Laravel

```text
app/
  Http/
    Controllers/
      Public/
        HomeController.php
        RegistrationController.php
      Admin/
        DashboardController.php
        StudentRegistrationController.php
        RegistrationPathController.php
        ReportController.php
    Requests/
      StoreStudentRegistrationRequest.php
      UpdateRegistrationStatusRequest.php
      UpdateRegistrationPathRequest.php
  Models/
    RegistrationPath.php
    StudentRegistration.php
  Services/
    RegistrationNumberService.php
    RegistrationCapacityService.php

resources/
  views/
    public/
      home.blade.php
      register.blade.php
      success.blade.php
    admin/
      dashboard.blade.php
      registrations/
        index.blade.php
        show.blade.php
      paths/
        index.blade.php
      reports/
        index.blade.php
        print.blade.php
    layouts/
      public.blade.php
      admin.blade.php
```

---

## 22. Rekomendasi Entity Relationship

Relasi utama:

```text
registration_paths 1 --- n student_registrations
users              1 --- n registration_status_logs, opsional
student_registrations 1 --- n registration_status_logs, opsional
```

Penjelasan:

* Satu jalur pendaftaran memiliki banyak data pendaftar.
* Setiap pendaftar hanya memilih satu jalur.
* Riwayat status bersifat opsional untuk kebutuhan audit.

---

## 23. Prioritas Backlog

### Priority 1 — Must Have

* Landing page.
* Form pendaftaran.
* Simpan data pendaftar.
* Login admin.
* Dashboard statistik.
* Pengaturan kapasitas.
* Tabel pendaftar.
* Export CSV.

### Priority 2 — Should Have

* Detail pendaftar.
* Update status.
* Filter laporan.
* Cetak bukti pendaftaran.
* Grafik dashboard.

### Priority 3 — Nice to Have

* Upload dokumen.
* Tracking pendaftaran publik.
* Notifikasi WhatsApp/email.
* Export PDF.
* Riwayat status.

---

## 24. Definisi Selesai

Aplikasi dianggap selesai untuk MVP jika:

* Landing page dapat diakses publik.
* Pendaftar dapat mengirim data prapendaftaran.
* Nomor prapendaftaran berhasil dibuat otomatis.
* Admin dapat login.
* Admin dapat melihat statistik pendaftar per jalur.
* Admin dapat mengatur kapasitas tiap jalur.
* Admin dapat melihat daftar dan detail pendaftar.
* Admin dapat mengekspor laporan CSV.
* Tampilan responsive di mobile dan desktop.
* Validasi form berjalan dengan baik.
* Tidak ada error utama pada alur pendaftaran dan dashboard.

---

## 25. Catatan Implementasi untuk Developer

* Mulai dari MVP, jangan langsung membuat fitur kompleks.
* Gunakan Blade agar aplikasi ringan dan cepat.
* Gunakan Tailwind CSS atau Bootstrap sesuai preferensi tim.
* Buat service khusus untuk logika kapasitas dan nomor pendaftaran.
* Buat database seeder untuk tiga jalur awal.
* Gunakan pagination pada tabel admin.
* Gunakan query filter yang sederhana dan mudah dirawat.
* Jangan jadikan sistem ini sebagai hasil seleksi final kecuali ada PRD lanjutan.

---

## 26. Ringkasan MVP Satu Kalimat

Aplikasi SPMB ini adalah landing page dan dashboard admin berbasis Laravel untuk mendata prapendaftaran murid baru berdasarkan jalur Domisili, Afirmasi, dan Prestasi, lengkap dengan pengaturan kapasitas serta laporan rekapitulasi sederhana.
