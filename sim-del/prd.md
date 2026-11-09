# Product Requirement Document (PRD)
# SIPUS-Del — Sistem Informasi Perpustakaan Kampus Del

---

## 1. Executive Summary & Problem Statement

### 1.1 Latar Belakang & Problem Statement
Institut Teknologi Del memerlukan sistem pencatatan dan pengelolaan inventaris perpustakaan modern yang terintegrasi. Saat ini, pencatatan katalog buku fisik dan pemantauan ketersediaan stok masih sering menghadapi kendala signifikan:
- **Pencatatan Manual yang Lambat & Rentan Galat**: Duplikasi nomor ISBN, kesalahan penulisan kategori, dan ketidaksinkronan data buku fisik dengan kartu katalog.
- **Ketiadaan Visibilitas Ketersediaan Buku Real-Time**: Civitas akademika (mahasiswa dan dosen) kesulitan mengetahui apakah buku yang dicari sedang tersedia di rak perpustakaan atau stoknya habis tanpa harus datang langsung secara fisik.
- **Kesulitan Pengelompokan Koleksi**: Klasifikasi buku ke dalam rumpun ilmu (Informatika, Sistem Informasi, Teknik Elektro, Sains Terapan, Sastra, dll.) belum terotomatisasi secara relasional.
- **Kebutuhan Sistem Web Terstruktur & Berperforma Tinggi**: Perlunya penerapan arsitektur perangkat lunak berbasis Server-Side Rendering (SSR) yang rapi, modular, aman dari kerentanan web standar (CSRF, XSS, SQL Injection), dan terbebas dari masalah inefisiensi kueri database (*N+1 Query Problem*).

### 1.2 Tujuan Produk (Product Objectives)
Membangun aplikasi web **SIPUS-Del** menggunakan arsitektur **Model-View-Controller (MVC)** pada **Laravel 11.x**, dengan basis data relasional **SQLite**, sistem komponen tampilan **Blade**, integrasi prototipe visual dari **Google Stitch**, serta optimasi kueri **Eloquent ORM** yang dilengkapi audit performa.

---

## 2. User Personas & Hak Akses

| Persona | Peran & Kebutuhan Utama | Aksi yang Diizinkan |
| :--- | :--- | :--- |
| **Pustakawan / Administrator Perpustakaan** | Bertanggung jawab penuh terhadap pemeliharaan koleksi, penambahan buku baru, pengelompokan kategori, dan pembaruan sisa stok. | • Melakukan CRUD lengkap pada entitas Kategori.<br>• Melakukan CRUD lengkap pada entitas Buku.<br>• Mengelola relasi buku dengan kategori induk.<br>• Memperbarui jumlah stok fisik dan sinopsis. |
| **Mahasiswa / Civitas Del (Guest Viewer)** | Membutuhkan akses cepat untuk mengeksplorasi katalog, memeriksa sisa stok buku, dan membaca sinopsis sebelum meminjam. | • Menelusuri seluruh katalog buku di Dashboard.<br>• Memfilter buku berdasarkan kategori.<br>• Melihat kartu detail lengkap buku (`show`).<br>• Melihat indikator status ketersediaan stok (Tersedia / Habis). |

---

## 3. Web Application User Flow

### 3.1 Alur Pengunjung (Mahasiswa / Guest)
```
[Buka Aplikasi]
       │
       ▼
[Landing / Katalog Buku] ──► (Filter Kategori / Cari Buku)
       │
       ▼
[Klik "Lihat Detail"]
       │
       ▼
[Halaman Detail Buku]
- Informasi Bibliografi Lengkap (ISBN, Penulis, Penerbit, Tahun)
- Status Stok (Badge Sage: "Tersedia" / Badge Amber: "Habis")
- Sinopsis Buku
```

### 3.2 Alur Pengelola Perpustakaan (Pustakawan)
```
[Navigasi Menu Admin]
       │
       ├────────────────────────────────────────┐
       ▼                                        ▼
[Manajemen Kategori]                     [Manajemen Buku]
  ├── Lihat Daftar Kategori (Tabel)        ├── Lihat Katalog Buku (Tabel + Badge)
  ├── Tambah Kategori Baru                 ├── Tambah Buku Baru (Pilih Kategori)
  ├── Edit Kategori                        ├── Edit Data Buku & Stok
  └── Hapus Kategori (Cascade ke Buku)     └── Hapus Koleksi Buku
```

---

## 4. Spesifikasi Fitur Utama (Core Features)

### 4.1 Modul Kategori (`kategoris`)
- **Tabel Daftar Kategori (`index`)**: Menampilkan daftar kode kategori, nama kategori, dan jumlah koleksi buku yang berelasi, dilengkapi tombol aksi edit dan hapus.
- **Pendaftaran Kategori Baru (`create` & `store`)**:
  - `kode_kategori`: String unik (maksimal 20 karakter, contoh: `INF`, `SI`, `MAT`).
  - `nama_kategori`: String (minimal 3, maksimal 100 karakter, contoh: `Teknologi & Komputasi`).
- **Pembaruan Kategori (`edit` & `update`)**: Form modifikasi dengan proteksi aturan validasi keunikan kode kategori yang mengabaikan ID record bersangkutan.
- **Penghapusan Kategori (`destroy`)**: Penghapusan data kategori dengan perilaku *cascade delete* pada buku yang terhubung, disertai konfirmasi keamanan form (`@method('DELETE')`).

### 4.2 Modul Buku (`bukus`)
- **Katalog & Tabel Buku (`index`)**: Menampilkan seluruh koleksi buku dengan informasi ISBN, judul, nama kategori (via Eager Loading), penulis, penerbit, tahun terbit, badge stok, dan pagination (10 data per halaman).
- **Detail Buku (`show`)**: Halaman detail komprehensif yang menampilkan seluruh atribut bibliografi buku, badge status stok, badge nama kategori, sinopsis naratif, dan tautan kembali.
- **Registrasi Buku Baru (`create` & `store`)**:
  - `isbn`: String 13 digit angka unik (contoh: `9786020385914`).
  - `judul`: String judul buku (minimal 5 karakter, maksimal 255 karakter).
  - `penulis`: String nama penulis (maksimal 150 karakter).
  - `penerbit`: String nama penerbit (maksimal 100 karakter).
  - `tahun_terbit`: Tahun terbit 4 digit angka (rentang 1900 s.d. tahun sekarang).
  - `kategori_id`: Foreign key wajib yang valid dari tabel `kategoris`.
  - `stok`: Bilangan bulat non-negatif (minimal 0, default 0).
  - `sinopsis`: Teks ringkasan/sinopsis buku (opsional/nullable).
- **Pembaruan Koleksi Buku (`edit` & `update`)**: Form perubahan data buku dengan pemuatan data lama (`old()` atau nilai saat ini) serta pengabaian ISBN unik untuk record yang sedang diedit.
- **Penghapusan Buku (`destroy`)**: Form hapus aman dengan token CSRF dan method spoofing DELETE.

---

## 5. Milestone Delivery System

Pembangunan SIPUS-Del dirancang dengan sistem **Milestone bertahap berorientasi Frontend-First**:

```mermaid
flowchart LR
    M0["Milestone 0: AI & Config"] --> M1["Milestone 1: Frontend (Google Stitch & Blade)"]
    M1 --> M2["Milestone 2: Database & Eloquent Models"]
    M2 --> M3["Milestone 3: Controllers & Validation"]
    M3 --> M4["Milestone 4: Performance Audit (N+1)"]
    M4 --> M5["Milestone 5: Verification & Git Final"]
```

1. **Milestone 0 — Inisialisasi & Tata Kelola**:
   - Pembuatan `.cursorrules` dan verifikasi database SQLite di `sim-del/.env`.
2. **Milestone 1 — Frontend-First Track (Google Stitch Integration & Blade Templates)**:
   - Pengadopsian prototipe visual dari paket Google Stitch (`stitch_design/stitch_sipus_del_library_system_plan/`).
   - Konstruksi Master Shell Layout `<x-layout>` bertema *"Warm Classy Academic"* (Del Royal Purple `#1E1A29`/`#312052`, Warm Cream `#FAF8F5`, aksen Amber `#B45309`).
   - Pembuatan seluruh berkas View untuk Kategori (`index`, `create`, `edit`) dan Buku (`index`, `show`, `create`, `edit`) menggunakan dummy mock data.
   - Penanganan komponen alert flash session dan status data kosong (`@forelse`).
3. **Milestone 2 — Backend Track: Skema Data & Model Eloquent**:
   - Pembuatan skema migration tabel `kategoris` dan `bukus` dengan foreign key berelasi.
   - Implementasi Active Record Model `Kategori` dan `Buku` lengkap dengan properti proteksi `$fillable` dan metode relasi `hasMany` / `belongsTo`.
   - Pembuatan Factory & Seeder Faker (minimal 5 kategori dan 20 buku realistis).
4. **Milestone 3 — Backend Track: Resource Controllers, Validasi, & Integrasi Data**:
   - Pendaftaran 7 rute RESTful resource di `routes/web.php`.
   - Implementasi `KategoriController` dan `BukuController` dengan validasi server-side `$request->validate()`.
   - Menghubungkan controller dengan seluruh antarmuka Blade yang sudah disiapkan pada Milestone 1.
5. **Milestone 4 — Query Audit & Mitigasi N+1**:
   - Penerapan Eager Loading `Buku::with('kategori')`.
   - Registrasi listener `DB::listen` pada `AppServiceProvider` untuk mencatat metrik kueri ke `storage/logs/laravel.log`.
   - Pembuktian bahwa halaman katalog buku hanya mengeksekusi tepat 2 kueri SQL terpadu.
6. **Milestone 5 — Quality Assurance & Git Submission**:
   - Pengujian fungsional seluruh alur CRUD.
   - Pengecekan keamanan kredensial `.env` dan verifikasi commit Conventional Commits.

---

## 6. Persyaratan Non-Fungsional (Non-Functional Requirements)

- **Keamanan (Security)**:
  - Proteksi penuh terhadap serangan Cross-Site Request Forgery (CSRF) pada setiap form mutasi data.
  - Sanitasi otomatis karakter khusus untuk mencegah Cross-Site Scripting (XSS) via Blade engine `{{ ... }}`.
  - Proteksi Mass Assignment pada seluruh model Eloquent via `$fillable`.
  - Perlindungan SQL Injection melalui PDO Prepared Statements bawaan Eloquent.
- **Performa & Skalabilitas (Performance)**:
  - Meniadakan N+1 Query Problem melalui penerapan Eager Loading (`with('kategori')`).
  - Pagination aktif pada tabel data buku guna menjaga beban memori server tetap ringan.
  - Response time rata-rata di bawah 100ms pada lingkungan pengujian lokal SQLite.
- **Kenyamanan Visual (Usability & Accessibility)**:
  - Estetika antarmuka *"Warm Classy Academic"* yang ramah di mata untuk sesi penggunaan panjang.
  - Hirarki tipografi jelas dengan kontras warna yang memenuhi standar keterbacaan.
  - Feedback interaktif instan (pesan sukses hijau emerald, pesan galat validasi merah terarah per input field).

