# Task Backlog & Progress Tracker (Milestone System)
# SIPUS-Del — Sistem Informasi Perpustakaan Kampus Del

---

## IKHTISAR ALUR PENGERJAAN (FRONTEND-FIRST PIPELINE)
Proyek ini mengadopsi pendekatan **Frontend-First**: Seluruh rancangan antarmuka pengguna (`resources/views/`) dikonstruksi terlebih dahulu dengan panduan prototipe visual dari **Google Stitch** (`stitch_design/`), sebelum melanjutkan ke pembangunan skema database, model Eloquent, controller, query audit, dan penyempurnaan frontend dengan Anime.js micro-interactions.

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
  - [x] Buat berkas `sim-del/resources/views/components/layout.blade.php`.
  - [x] Implementasikan Navbar bernuansa Del Heritage Aubergine (`#1E1A29`), Del Royal Purple (`#4C1D95`), logo monogram Del, dan menu navigasi responsif.
  - [x] Integrasikan tipografi `Plus Jakarta Sans` dan `JetBrains Mono` via Google Fonts.
  - [x] Tambahkan styling dasar tema *"Warm Classy Academic"* (kanvas `#FAF8F5`, kartu `#FFFFFF`, border `#E8E2D8`).
  - [x] Siapkan kontainer slot dinamis `{{ $slot }}` dan footer kampus Institut Teknologi Del.
- [x] **1.2 Komponen Pendukung Blade**:
  - [x] Buat komponen alert notifikasi flash session (`components/flash-alert.blade.php`) untuk `session('success')` dan `session('error')`.
  - [x] Buat komponen visual status koleksi kosong (`components/empty-state.blade.php`).
- [x] **1.3 Antarmuka Manajemen Kategori**:
  - [x] `resources/views/kategori/index.blade.php`: Tabel daftar kategori, badge jumlah buku, tombol tambah, edit, hapus, dan penanganan `@forelse`.
  - [x] `resources/views/kategori/create.blade.php`: Formulir input kategori (`kode_kategori`, `nama_kategori`) lengkap dengan `@csrf`, input text classy, dan umpan balik `@error`.
  - [x] `resources/views/kategori/edit.blade.php`: Formulir edit data kategori dengan data binding lama `old()`, token `@csrf`, method spoofing `@method('PUT')`, dan penanganan `@error`.
- [x] **1.4 Antarmuka Katalog & Manajemen Buku**:
  - [x] `resources/views/buku/index.blade.php`: Dashboard katalog buku berestetika Warm & Classy mengacu pada `sipus_del_katalog_buku_dashboard_warm_classy/code.html`, badge nama kategori Burnished Amber (`#B45309`), badge ketersediaan stok Academic Sage (`#475E4E`), tombol aksi CRUD, pagination links, dan `@forelse`.
  - [x] `resources/views/buku/show.blade.php`: Halaman detail buku mengacu pada `sipus_del_detail_buku_show/code.html`, metadata bibliografi (ISBN, Penulis, Penerbit, Tahun), status stok besar, dan sinopsis naratif.
  - [x] `resources/views/buku/create.blade.php`: Formulir registrasi buku baru mengacu pada `sipus_del_formulir_registrasi_edit_buku/code.html`, dropdown select kategori relasional, input angka stok, textarea sinopsis, proteksi `@csrf`, dan umpan balik `@error`.
  - [x] `resources/views/buku/edit.blade.php`: Formulir edit data buku dengan data binding `old()`, token `@csrf`, method spoofing `@method('PUT')`, dan penanganan `@error`.
- [x] **1.5 Milestone Commit (Frontend)**:
  ```powershell
  git add sim-del/resources/views sim-del/resources/css
  git commit -m "feat(views): construct blade component layout and crud templates"
  ```

---

## MILESTONE 2: BACKEND TRACK (DATABASE, MIGRATIONS & ELOQUENT MODELS)
*Fokus: Membangun skema database berversi, model relasional Eloquent, dan otomasi mock data realistis.*

- [x] **2.1 Skema Migrasi Database**:
  - [x] Jalankan artisan CLI untuk migrasi tabel `kategoris`:
    ```powershell
    cd sim-del; php artisan make:migration create_kategoris_table
    ```
  - [x] Lengkapi kolom tabel `kategoris`: `id`, `kode_kategori` (unique), `nama_kategori`, `timestamps`.
  - [x] Jalankan artisan CLI untuk migrasi tabel `bukus`:
    ```powershell
    cd sim-del; php artisan make:migration create_bukus_table
    ```
  - [x] Lengkapi kolom tabel `bukus`: `id`, `isbn` (unique 13 digit), `judul`, `penulis`, `penerbit`, `tahun_terbit`, `kategori_id` (`foreignId` cascade on delete), `stok` (min 0), `sinopsis`, `timestamps`.
  - [x] Eksekusi migrasi database:
    ```powershell
    cd sim-del; php artisan migrate
    ```
- [x] **2.2 Model Eloquent & Relasi Kardinalitas**:
  - [x] Buat model `app/Models/Kategori.php` dengan `$fillable = ['kode_kategori', 'nama_kategori']` dan relasi `public function bukus(): HasMany`.
  - [x] Buat model `app/Models/Buku.php` dengan `$fillable` lengkap dan relasi `public function kategori(): BelongsTo`.
- [x] **2.3 Factories & Database Seeder (Faker)**:
  - [x] Buat `database/factories/KategoriFactory.php` untuk men-generate data bidang ilmu perpustakaan.
  - [x] Buat `database/factories/BukuFactory.php` untuk men-generate ISBN 13 digit, judul ilmiah, penulis, penerbit ternama, stok (0-15), dan sinopsis.
  - [x] Susun `database/seeders/DatabaseSeeder.php` untuk menyuntikkan **minimal 5 Kategori** dan **minimal 20 Buku** realistis.
  - [x] Eksekusi migrasi ulang & seeder:
    ```powershell
    cd sim-del; php artisan migrate:fresh --seed
    ```

---

## MILESTONE 3: BACKEND TRACK (RESOURCE CONTROLLERS, VALIDATION & ROUTING)
*Fokus: Mengimplementasikan 7 aksi CRUD pada Controller, validasi server-side ketat, dan menghubungkan data ke Blade Views.*

- [x] **3.1 Registrasi Rute RESTful di `routes/web.php`**:
  - [x] Redirect root URL `/` ke `/buku`.
  - [x] Daftarkan `Route::resource('kategori', KategoriController::class);`.
  - [x] Daftarkan `Route::resource('buku', BukuController::class);`.
- [x] **3.2 Implementasi `KategoriController`**:
  - [x] `index()`: Mengambil daftar kategori beserta jumlah buku (`withCount('bukus')`).
  - [x] `create()`: Menampilkan form tambah kategori.
  - [x] `store()`: Validasi `$request->validate()` (`kode_kategori` unique, `nama_kategori` min 3) dan simpan record baru.
  - [x] `edit()`: Menampilkan form edit kategori.
  - [x] `update()`: Validasi update dengan mengabaikan ID kategori saat ini dan simpan perubahan.
  - [x] `destroy()`: Hapus record kategori dengan cascade delete pada buku terkait.
- [x] **3.3 Implementasi `BukuController`**:
  - [x] `index()`: Mengambil daftar buku terurut terbaru dengan Eager Loading (`with('kategori')`) dan pagination 10 data.
  - [x] `show()`: Menampilkan kartu detail buku dengan memuat relasi kategori.
  - [x] `create()`: Mengambil seluruh kategori untuk mengisi opsi dropdown select dan menampilkan form.
  - [x] `store()`: Validasi ketat sisi server (ISBN 13 digit unik, judul min 5 char, stok min 0, kategori_id exists) dan simpan record baru.
  - [x] `edit()`: Membuka form edit dengan mengisi data kategori untuk dropdown.
  - [x] `update()`: Validasi update (ISBN unik ignore current ID, stok min 0) dan perbarui record.
  - [x] `destroy()`: Menghapus buku dari sistem dengan redirect flash message.
- [x] **3.4 Integrasi Dinamis Controller ke Views**:
  - [x] Pastikan seluruh view Blade yang dibuat di Milestone 1 kini terisi variabel dinamis dari controller.
  - [x] Pastikan form mengarah ke route aksi yang benar (`route('buku.store')`, `route('buku.update', $buku)`, dsb.).

---

## MILESTONE 4: QUERY OPTIMIZATION & PERFORMANCE AUDIT
*Fokus: Mengaudit kueri database untuk menjamin ketiadaan N+1 Query Problem.*

- [x] **4.1 Konfigurasi `DB::listen` di `AppServiceProvider`**:
  - [x] Buka `sim-del/app/Providers/AppServiceProvider.php`.
  - [x] Tambahkan konfigurasi `Paginator::useBootstrapFive();`.
  - [x] Tambahkan listener `DB::listen` yang menulis log berformat `[SQL AUDIT] (%.2f ms) %s` ke `storage/logs/laravel.log`.
- [x] **4.2 Eksekusi Uji Audit Kueri**:
  - [x] Jalankan server: `cd sim-del; php artisan serve`.
  - [x] Buka peramban pada `http://localhost:8000/buku`.
  - [x] Periksa berkas `sim-del/storage/logs/laravel.log`.
  - [x] **Verifikasi Kritis**: Tepat 2 kueri SQL terpadu untuk 10 buku dan kategorinya (N+1 query problem berhasil dieliminasi).

---

## MILESTONE 5: FRONTEND ENHANCEMENT & ANIME.JS ORCHESTRATION
*Fokus: Memperkaya pengalaman visual dengan Anime.js v4 micro-interactions dan estetika Warm & Classy Academic.*

- [x] **5.1 Integrasi Anime.js v4**:
  - [x] Konfigurasi modul `resources/js/animations.js` dengan ES Module syntax `import { animate, stagger } from 'animejs'`.
  - [x] Hubungkan modul animasi pada `resources/js/app.js` saat event `DOMContentLoaded`.
- [x] **5.2 Micro-Interactions Terorkestrasi**:
  - [x] Metric Count-Up Counters pada 4 kartu statistik katalog buku.
  - [x] Staggered Cascade Entrance pada baris tabel dan grid kartu monograf.
  - [x] View Switcher (Tabel Klasik vs Grid Kartu Monograf 3D Tome) dengan transisi animasi.
  - [x] Quick Filter Chips kategori untuk navigasi cepat.
  - [x] Live Monograph Preview pada Form Tambah & Edit Buku (layout 2 kolom responsif).
  - [x] Floating Flash Alert Pop-In dengan auto-dismiss.
  - [x] Copy to Clipboard interaktif dengan animasi ikon dan feedback visual.
  - [x] Global Keyboard Shortcut (`/` untuk fokus ke pencarian).
- [x] **5.3 Kompilasi Vite Asset Bundling**:
  - [x] Jalankan `npm run build` untuk menghasilkan bundle produksi terkompilasi di `public/build/`.

---

## MILESTONE 6: VERIFICATION, QUALITY ASSURANCE & GIT SUBMISSION
*Fokus: Pengujian menyeluruh, pengecekan keamanan berkas, dan finalisasi repositori.*

- [x] **6.1 Pengujian Alur Fungsional (End-to-End Manual Testing)**:
  - [x] Uji skenario sukses (Happy Path): Tambah kategori -> Tambah buku -> Tampil di katalog -> Detail buku -> Edit buku -> Hapus buku.
  - [x] Uji skenario gagal validasi (Unhappy Path): Masukkan ISBN kurang dari 13 digit / duplikat -> Pesan error validasi merah muncul tepat di bawah input tanpa reset isian input lain.
  - [x] Uji hapus kategori: Pastikan buku yang berafiliasi ikut terhapus (*cascade delete*) tanpa menimbulkan error constraint.
- [x] **6.2 Audit Keamanan Berkas & `.gitignore`**:
  - [x] Pastikan berkas `.env` dan folder `vendor/` terdaftar di `.gitignore` dan TIDAK ter-commit ke repositori Git.
  - [x] Pastikan `.agents/` terdaftar di `.gitignore` root repositori.
- [x] **6.3 Dokumentasi & Git Synchronization**:
  - [x] Perbarui `README.md` utama dengan petunjuk instalasi, fitur frontend baru, dan penjelasan port (8000 vs 5173).
  - [x] Push perubahan ke branch `main` dan branch `week5-MVC`.
