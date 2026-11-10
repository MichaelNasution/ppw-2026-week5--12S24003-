# Task Backlog & Progress Tracker (Milestone System)
# SIPUS-Del — Sistem Informasi Perpustakaan Kampus Del

---

## IKHTISAR ALUR PENGERJAAN (FRONTEND-FIRST PIPELINE)
Proyek ini mengadopsi pendekatan **Frontend-First**: Seluruh rancangan antarmuka pengguna (`resources/views/`) dikonstruksi terlebih dahulu dengan panduan prototipe visual dari **Google Stitch** (`stitch_design/`), sebelum melanjutkan ke pembangunan skema database, model Eloquent, controller, dan query audit.

---

## MILESTONE 0: INITIALIZATION & GOVERNANCE
- [x] **0.1 Setup AI Rules**: Buat berkas panduan AI `.cursorrules` di dalam direktori `sim-del/`.
- [x] **0.2 Setup Perencanaan Proyek**: Buat berkas `prd.md`, `tech-stack.md`, `design.md`, `schema.md`, dan `todo.md` di `sim-del/`.
- [x] **0.3 Ekstrak Desain Google Stitch**: Buka dan periksa seluruh berkas prototipe Google Stitch di `stitch_design/stitch_sipus_del_library_system_plan/`.
- [x] **0.4 Verifikasi Lingkungan SQLite**: Periksa berkas `sim-del/.env` untuk memastikan `DB_CONNECTION=sqlite` aktif dan `database/database.sqlite` siap digunakan.

---

## MILESTONE 1: FRONTEND TRACK (GOOGLE STITCH PROTOTYPE TO BLADE ENGINE)
*Fokus: Membangun Master Shell Layout, komponen modular, dan seluruh tampilan View dengan data presentasional sebelum dihubungkan ke database.*

- [x] **1.1 Master Shell Component Layout (`<x-layout>`)**:
  - [ ] Buat berkas `sim-del/resources/views/components/layout.blade.php`.
  - [ ] Implementasikan Navbar bernuansa Del Heritage Aubergine (`#1E1A29`), Del Royal Purple (`#4C1D95`), logo monogram Del, dan menu navigasi responsif.
  - [ ] Integrasikan tipografi `Plus Jakarta Sans` dan `JetBrains Mono` via Google Fonts.
  - [ ] Tambahkan styling dasar tema *"Warm Classy Academic"* (kanvas `#FAF8F5`, kartu `#FFFFFF`, border `#E8E2D8`).
  - [ ] Siapkan kontainer slot dinamis `{{ $slot }}` dan footer kampus Institut Teknologi Del.
- [x] **1.2 Komponen Pendukung Blade**:
  - [ ] Buat komponen alert notifikasi flash session (`components/flash-alert.blade.php`) untuk `session('success')` dan `session('error')`.
  - [ ] Buat komponen visual status koleksi kosong (`components/empty-state.blade.php`).
- [x] **1.3 Antarmuka Manajemen Kategori**:
  - [ ] `resources/views/kategori/index.blade.php`: Tabel daftar kategori, badge jumlah buku, tombol tambah, edit, hapus, dan penanganan `@forelse`.
  - [ ] `resources/views/kategori/create.blade.php`: Formulir input kategori (`kode_kategori`, `nama_kategori`) lengkap dengan `@csrf`, input text classy, dan umpan balik `@error`.
  - [ ] `resources/views/kategori/edit.blade.php`: Formulir edit data kategori dengan data binding lama `old()`, token `@csrf`, method spoofing `@method('PUT')`, dan penanganan `@error`.
- [x] **1.4 Antarmuka Katalog & Manajemen Buku**:
  - [ ] `resources/views/buku/index.blade.php`: Dashboard katalog buku berestetika Warm & Classy mengacu pada `sipus_del_katalog_buku_dashboard_warm_classy/code.html`, badge nama kategori Burnished Amber (`#B45309`), badge ketersediaan stok Academic Sage (`#475E4E`), tombol aksi CRUD, pagination links, dan `@forelse`.
  - [ ] `resources/views/buku/show.blade.php`: Halaman detail buku mengacu pada `sipus_del_detail_buku_show/code.html`, metadata bibliografi (ISBN, Penulis, Penerbit, Tahun), status stok besar, dan sinopsis naratif.
  - [ ] `resources/views/buku/create.blade.php`: Formulir registrasi buku baru mengacu pada `sipus_del_formulir_registrasi_edit_buku/code.html`, dropdown select kategori relasional, input angka stok, textarea sinopsis, proteksi `@csrf`, dan umpan balik `@error`.
  - [ ] `resources/views/buku/edit.blade.php`: Formulir edit data buku dengan data binding `old()`, token `@csrf`, method spoofing `@method('PUT')`, dan penanganan `@error`.
- [x] **1.5 Milestone Commit (Frontend)**:
  ```powershell
  git add sim-del/resources/views sim-del/resources/css
  git commit -m "feat(views): construct blade component layout and crud templates"
  ```

---

## MILESTONE 2: BACKEND TRACK (DATABASE, MIGRATIONS & ELOQUENT MODELS)
*Fokus: Membangun skema database berversi, model relasional Eloquent, dan otomasi mock data realistis.*

- [ ] **2.1 Skema Migrasi Database**:
  - [ ] Jalankan artisan CLI untuk migrasi tabel `kategoris`:
    ```powershell
    cd sim-del; php artisan make:migration create_kategoris_table
    ```
  - [ ] Lengkapi kolom tabel `kategoris`: `id`, `kode_kategori` (unique), `nama_kategori`, `timestamps`.
  - [ ] Jalankan artisan CLI untuk migrasi tabel `bukus`:
    ```powershell
    cd sim-del; php artisan make:migration create_bukus_table
    ```
  - [ ] Lengkapi kolom tabel `bukus`: `id`, `isbn` (unique 13 digit), `judul`, `penulis`, `penerbit`, `tahun_terbit`, `kategori_id` (`foreignId` cascade on delete), `stok` (min 0), `sinopsis`, `timestamps`.
  - [ ] Eksekusi migrasi database:
    ```powershell
    cd sim-del; php artisan migrate
    ```
  - [ ] **Milestone Commit (Migrations)**:
    ```powershell
    git add sim-del/database/migrations
    git commit -m "feat(migration): create kategoris and bukus tables schema"
    ```
- [ ] **2.2 Model Eloquent & Relasi Kardinalitas**:
  - [ ] Buat model `app/Models/Kategori.php` dengan `$fillable = ['kode_kategori', 'nama_kategori']` dan relasi `public function bukus(): HasMany`.
  - [ ] Buat model `app/Models/Buku.php` dengan `$fillable` lengkap dan relasi `public function kategori(): BelongsTo`.
  - [ ] **Milestone Commit (Models)**:
    ```powershell
    git add sim-del/app/Models
    git commit -m "feat(model): define relationships and fillable attributes"
    ```
- [ ] **2.3 Factories & Database Seeder (Faker)**:
  - [ ] Buat `database/factories/KategoriFactory.php` untuk men-generate data bidang ilmu perpustakaan.
  - [ ] Buat `database/factories/BukuFactory.php` untuk men-generate ISBN 13 digit, judul ilmiah, penulis, penerbit ternama, stok (0-15), dan sinopsis.
  - [ ] Susun `database/seeders/DatabaseSeeder.php` untuk menyuntikkan **minimal 5 Kategori** dan **minimal 20 Buku** realistis.
  - [ ] Eksekusi migrasi ulang & seeder:
    ```powershell
    cd sim-del; php artisan migrate:fresh --seed
    ```
  - [ ] **Milestone Sub-Commit (Seeder)**:
    ```powershell
    git add sim-del/database/factories sim-del/database/seeders
    git commit -m "feat(seeder): seed 5 categories and 20 realistic books with faker"
    ```

---

## MILESTONE 3: BACKEND TRACK (RESOURCE CONTROLLERS, VALIDATION & ROUTING)
*Fokus: Mengimplementasikan 7 aksi CRUD pada Controller, validasi server-side ketat, dan menghubungkan data ke Blade Views.*

- [ ] **3.1 Registrasi Rute RESTful di `routes/web.php`**:
  - [ ] Redirect root URL `/` ke `/buku`.
  - [ ] Daftarkan `Route::resource('kategori', KategoriController::class);`.
  - [ ] Daftarkan `Route::resource('buku', BukuController::class);`.
- [ ] **3.2 Implementasi `KategoriController`**:
  - [ ] `index()`: Mengambil daftar kategori beserta jumlah buku (`withCount('bukus')`).
  - [ ] `create()`: Menampilkan form tambah kategori.
  - [ ] `store()`: Validasi `$request->validate()` (`kode_kategori` unique, `nama_kategori` min 3) dan simpan record baru.
  - [ ] `edit()`: Menampilkan form edit kategori.
  - [ ] `update()`: Validasi update dengan mengabaikan ID kategori saat ini dan simpan perubahan.
  - [ ] `destroy()`: Hapus record kategori dengan cascade delete pada buku terkait.
- [ ] **3.3 Implementasi `BukuController`**:
  - [ ] `index()`: Mengambil daftar buku terurut terbaru dengan Eager Loading (`with('kategori')`) dan pagination 10 data.
  - [ ] `show()`: Menampilkan kartu detail buku dengan memuat relasi kategori.
  - [ ] `create()`: Mengambil seluruh kategori untuk mengisi opsi dropdown select dan menampilkan form.
  - [ ] `store()`: Validasi ketat sisi server (ISBN 13 digit unik, judul min 5 char, stok min 0, kategori_id exists) dan simpan record baru.
  - [ ] `edit()`: Membuka form edit dengan mengisi data kategori untuk dropdown.
  - [ ] `update()`: Validasi update (ISBN unik ignore current ID, stok min 0) dan perbarui record.
  - [ ] `destroy()`: Menghapus buku dari sistem dengan redirect flash message.
- [ ] **3.4 Integrasi Dinamis Controller ke Views**:
  - [ ] Pastikan seluruh view Blade yang dibuat di Milestone 1 kini terisi variabel dinamis dari controller.
  - [ ] Pastikan form mengarah ke route aksi yang benar (`route('buku.store')`, `route('buku.update', $buku)`, dsb.).
  - [ ] **Milestone Commit (Controllers)**:
    ```powershell
    git add sim-del/app/Http/Controllers sim-del/routes/web.php sim-del/resources/views
    git commit -m "feat(controller): implement restful actions and server validation"
    ```

---

## MILESTONE 4: QUERY OPTIMIZATION & PERFORMANCE AUDIT
*Fokus: Mengaudit kueri database untuk menjamin ketiadaan N+1 Query Problem.*

- [ ] **4.1 Konfigurasi `DB::listen` di `AppServiceProvider`**:
  - [ ] Buka `sim-del/app/Providers/AppServiceProvider.php`.
  - [ ] Tambahkan konfigurasi `Paginator::useBootstrapFive();`.
  - [ ] Tambahkan listener `DB::listen` yang menulis log berformat `[SQL AUDIT] (%.2f ms) %s` ke `storage/logs/laravel.log`.
- [ ] **4.2 Eksekusi Uji Audit Kueri**:
  - [ ] Jalankan server: `cd sim-del; php artisan serve`.
  - [ ] Buka peramban pada `http://localhost:8000/buku`.
  - [ ] Periksa berkas `sim-del/storage/logs/laravel.log`.
  - [ ] **Verifikasi Kritis**: Pastikan hanya ada tepat **2 kueri SQL** terpadu yang tereksekusi untuk memuat seluruh 10 data buku beserta data kategorinya (Membuktikan bahwa N+1 query problem berhasil dieliminasi!).
- [ ] **4.3 Milestone Commit (Performance Audit)**:
  ```powershell
  git add sim-del/app/Providers/AppServiceProvider.php
  git commit -m "perf(eager-loading): optimize sql queries to prevent n+1 problem"
  ```

---

## MILESTONE 5: VERIFICATION, QUALITY ASSURANCE & GIT SUBMISSION
*Fokus: Pengujian menyeluruh, pengecekan keamanan berkas, dan finalisasi repositori.*

- [ ] **5.1 Pengujian Alur Fungsional (End-to-End Manual Testing)**:
  - [ ] Uji skenario sukses (Happy Path): Tambah kategori -> Tambah buku -> Tampil di katalog -> Detail buku -> Edit buku -> Hapus buku.
  - [ ] Uji skenario gagal validasi (Unhappy Path): Masukkan ISBN kurang dari 13 digit / duplikat -> Pesan error validasi merah muncul tepat di bawah input tanpa reset isian input lain.
  - [ ] Uji hapus kategori: Pastikan buku yang berafiliasi ikut terhapus (*cascade delete*) tanpa menimbulkan error constraint.
- [ ] **5.2 Audit Keamanan Berkas & `.gitignore`**:
  - [ ] Pastikan berkas `.env` dan folder `vendor/` terdaftar di `.gitignore` dan TIDAK ter-commit ke repositori Git.
  - [ ] Pastikan berkas `.env.example` tersedia dengan konfigurasi SQLite yang valid.
- [ ] **5.3 Dokumentasi & Log Laporan**:
  - [ ] Perbarui `README.md` utama dengan petunjuk instalasi proyek, ringkasan fitur, dan cuplikan bukti audit log SQL Eager Loading.
  - [ ] **Final Commit**:
    ```powershell
    git add README.md
    git commit -m "docs: complete project documentation and eager loading audit report"
    ```



