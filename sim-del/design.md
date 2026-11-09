# Design System: Warm Classy Academic Elegance
# SIPUS-Del — Sistem Informasi Perpustakaan Kampus Del

---

## 1. Filosofi & Karakter Visual (Brand Personality)

Design System **SIPUS-Del** mengusung tema **"Warm Classy Academic Elegance"**. Desain ini dirancang untuk menciptakan pengalaman digital perpustakaan kampus terkemuka yang terhormat, menenangkan, dan memancarkan wibawa intelektual.

### Pilar Karakter:
- **Scholarly & Poised**: Mewakili integritas dan otoritas akademik Institut Teknologi Del tanpa kesan kaku atau birokratis.
- **Warm & Welcoming**: Mengadopsi kehangatan ruang baca berkontur kayu jati (*reading room*), kertas buku linen klasik (*parchment*), dan pencahayaan alami yang meminimalkan kelelahan mata (*eye-strain*) selama riset panjang.
- **Contemporary Editorial**: Tata letak grid terstruktur, hierarki tipografi tegas, batas kartu bersudut lembut (*rounded borders*), dan bayangan ambient hangat yang tak mencolok.

---

## 2. Palet Warna (Color Palette Architecture)

Palet warna menggabungkan warna resmi kebanggaan Institut Teknologi Del (Royal Purple) dengan warna-warna organik bahan buku klasik dan batu alam:

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       WARM CLASSY ACADEMIC PALETTE                          │
├───────────────────┬───────────────────┬───────────────────┬─────────────────┤
│ Del Heritage      │ Linen Parchment   │ Burnished Amber   │ Academic Sage   │
│ Aubergine/Purple  │ Base Canvas       │ Secondary Accent  │ Success / Stock │
│ #1E1A29 / #312052 │ #FAF8F5 / #FAF7F2 │ #B45309 / #D97706 │ #475E4E         │
└───────────────────┴───────────────────┴───────────────────┴─────────────────┘
```

### 2.1 Nilai Heksadesimal & Peran Semantik

| Token Warna | Nilai HEX | Peran & Penggunaan Antarmuka |
| :--- | :--- | :--- |
| **Del Heritage Aubergine** | `#1E1A29` | Background navbar utama, header brand, teks heading paling tinggi. |
| **Del Royal Purple (Modul)** | `#4C1D95` | Aksen warna resmi Del, border aktif, icon highlight, hover links. |
| **Del Deep Indigo CTA** | `#312052` | Tombol aksi utama (*primary button*), tombol "Tambah Buku", "Simpan". |
| **Del Deep Hover** | `#251F33` / `#3B0764` | Status *hover* dan *active* pada tombol aksi utama. |
| **Linen Canvas (Base)** | `#FAF8F5` | Background dasar seluruh halaman aplikasi (mencegah silau putih murni). |
| **Parchment Surface Low** | `#FAF7F2` | Background kontainer tabel selang-seling, input area resting state. |
| **Card Surface (Pure White)** | `#FFFFFF` | Permukaan kartu (*card*), modal dialog, dan dropdown menu. |
| **Warm Stone Border** | `#E8E2D8` | Garis pembatas kartu, garis tabel, pemisah navigasi (*subtle boundary*). |
| **Burnished Amber (Gold)** | `#B45309` | Badge nama kategori, indikator stok menipis, bintang favorit, aksen buku. |
| **Amber Badge Fill** | `#FDF8F0` / `#F8ECDC` | Background lembut untuk pill badge kategori. |
| **Academic Sage (Green)** | `#475E4E` | Status stok tersedia ("Tersedia di Rak"), alert notifikasi sukses. |
| **Sage Badge Fill** | `#F2F7F4` / `#E2EFE7` | Background badge ketersediaan buku. |
| **Ruby Burgundy (Red)** | `#991B1B` / `#BA1A1A` | Tombol aksi hapus, pesan kesalahan validasi input (`is-invalid`). |
| **Charcoal Ink (Body Text)** | `#26211E` / `#1F1B17` | Teks utama body, judul kartu, data tabel. |
| **Warm Slate (Meta Text)** | `#78716C` / `#49454E` | Keterangan penulis, tahun terbit, nomor halaman, label form. |

---

## 3. Sistem Tipografi (Typography System)

Tipografi memprioritaskan kenyamanan membaca katalog yang memuat banyak metadata:

```
Headline / Display : Plus Jakarta Sans (Bold, Semi-Bold, Editorial Tracking -0.015em)
Body & Label       : Plus Jakarta Sans (Regular 400, Medium 500)
Code / Data ID     : JetBrains Mono (Medium 500, Regular 400) -> ISBN & Kode Kategori
```

### Skala Tipografi:
- **Display LG / Hero Title**: `32px` - `40px` (Weight 700, Line-height 1.25)
- **Page Title / Section Title**: `24px` - `28px` (Weight 600, Line-height 1.3)
- **Card Title / Book Title**: `18px` - `20px` (Weight 600, Line-height 1.4)
- **Body Regular**: `15px` - `16px` (Weight 400, Line-height 1.6, `#26211E`)
- **Metadata / Small Label**: `12px` - `13px` (Weight 500, `#78716C`)
- **Mono Identifiers**: `12px` - `13px` (`JetBrains Mono`, tracking +0.02em)

---

## 4. Pemetaan Prototipe Google Stitch ke Template Blade

Hasil ekspor dari **Google Stitch** (`stitch_design/stitch_sipus_del_library_system_plan/`) telah dianalisis dan dipetakan langsung ke arsitektur berkas Blade di `resources/views/`:

| Direktori Hasil Google Stitch | Berkas Prototipe | Target Berkas Blade di Laravel |
| :--- | :--- | :--- |
| **`warm_classy_academic/`** | `DESIGN.md` | `resources/css/app.css` & `resources/views/components/layout.blade.php` |
| **`sipus_del_katalog_buku_dashboard_warm_classy/`** | `code.html` + `screen.png` | `resources/views/buku/index.blade.php` (Katalog Buku, Filter, Pagination) |
| **`sipus_del_detail_buku_show/`** | `code.html` | `resources/views/buku/show.blade.php` (Detail Bibliografi & Sinopsis) |
| **`sipus_del_formulir_registrasi_edit_buku/`** | `code.html` | `resources/views/buku/create.blade.php` & `buku/edit.blade.php` |
| **`sipus_del_manajemen_kategori_buku/`** | `code.html` + `screen.png` | `resources/views/kategori/index.blade.php`, `kategori/create`, `kategori/edit` |

---

## 5. Spesifikasi Komponen Inti (Core Components)

### 5.1 Master Shell Layout (`<x-layout>`)
- **Header / Navbar**:
  - Warna latar: `#1E1A29` (Aubergine) dengan border bawah `#2F293F`.
  - Logo Institut Teknologi Del dengan lencana monogram Del dan teks kebanggaan *"Institut Teknologi Del — Perpustakaan"*.
  - Navigasi: Menu aktif "Katalog Buku" (`route('buku.index')`) dan "Manajemen Kategori" (`route('kategori.index')`).
  - Search bar cepat dengan icon `search` dan border hangat.
- **Main Content Area**:
  - Background kanvas: `#FAF8F5`.
  - Padding vertikal lega (`py-8` s.d. `py-12`) dengan kontainer maksimal `max-w-7xl` / `container`.
- **Footer**:
  - Latar belakang warm espresso dengan informasi hak cipta, alamat Kampus Del Sitoluama, Laguboti, dan tautan kebijakan peminjaman.

### 5.2 Komponen Notifikasi Flash (`components/flash-alert.blade.php`)
- **Notifikasi Sukses (`session('success')`)**:
  - Border kiri tebal (4px) berwarna Academic Sage (`#475E4E`).
  - Latar belakang sage lembut (`#F2F7F4`), teks warna hijau zaitun tua (`#2D5F43`).
  - Dilengkapi ikon centang dan tombol tutup (*dismissible*).
- **Notifikasi Galat (`session('error')`)**:
  - Border kiri tebal Ruby Burgundy (`#991B1B`).
  - Latar belakang kemerahan lembut (`#FDF2F2`), teks warna `#7F1D1D`.

### 5.3 Komponen Penanganan Status Kosong (`@forelse ... @empty`)
Setiap tabel atau grid buku/kategori wajib memiliki visual fallback saat koleksi kosong:
```blade
@forelse ($bukus as $buku)
    {{-- Baris atau Kartu Buku --}}
@empty
    <tr>
        <td colspan="7" class="text-center py-12">
            <div class="empty-state-wrapper py-6">
                <div class="empty-icon-circle mx-auto mb-3" style="width: 64px; height: 64px; background: #FAF7F2; border: 1px dashed #DDD2C2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined text-muted" style="font-size: 32px; color: #B4681E;">menu_book</span>
                </div>
                <h5 class="fw-bold" style="color: #26211E;">Belum Ada Koleksi Buku</h5>
                <p class="text-muted small mb-3">Koleksi perpustakaan masih kosong atau tidak ditemukan.</p>
                <a href="{{ route('buku.create') }}" class="btn btn-sm btn-del">
                    <i class="bi bi-plus-lg"></i> Tambah Buku Perdana
                </a>
            </div>
        </td>
    </tr>
@endforelse
```

### 5.4 Formulir & Feedback Validasi Error (`@error`)
- Input form dirancang dengan label melayang (*floating*) atau label atas tegas berwarna `#26211E`.
- Ketika validasi server-side gagal, input otomatis mendapatkan kelas `is-invalid` (border merah `#991B1B`) dan pesan galat ditampilkan persis di bawah field terkait:
```blade
<div class="mb-3">
    <label for="isbn" class="form-label fw-semibold text-secondary small">NOMOR ISBN (13 DIGIT)</label>
    <input type="text" name="isbn" id="isbn" 
           class="form-control form-control-classy @error('isbn') is-invalid @enderror"
           value="{{ old('isbn', $buku->isbn ?? '') }}" placeholder="Contoh: 9786020385914">
    @error('isbn')
        <div class="invalid-feedback fw-medium small text-danger mt-1">
            {{ $message }}
        </div>
    @enderror
</div>
```

### 5.5 Badge Status Stok & Kategori
- **Kategori**: Pill bersudut penuh (*rounded-full*) dengan latar `#FDF8F0`, border `#F3E1C8`, dan teks Burnished Amber `#9A5B18`.
- **Stok Tersedia**: Pill dengan latar `#F2F7F4`, border `#CCE3D6`, dan teks Academic Sage `#2D5F43` (contoh: "Tersedia: 8 Eks").
- **Stok Habis**: Pill dengan latar `#FDF2F2`, border `#FECACA`, dan teks Ruby `#991B1B` (contoh: "Stok Habis").

