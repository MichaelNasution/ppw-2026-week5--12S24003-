# ppw-2026-week5--12S24003

Praktikum Pemrograman & Pengujian Web (12S3101) &bull; Institut Teknologi Del  
**Modul Minggu 05**: Implementasi Pola Arsitektur Model-View-Controller (MVC), Request Lifecycle, Eloquent ORM, Validasi Server-Side, Blade Component Engine, dan Asset Bundling Vite pada Laravel 11.x.

---

## 🏛️ SIPUS-Del — Sistem Informasi Perpustakaan Kampus Del

Aplikasi utama berada di dalam direktori [`sim-del/`](./sim-del/).

### 📖 Panduan Lengkap & Dokumentasi:
- **Panduan Menjalankan Aplikasi**: [sim-del/README.md](./sim-del/README.md)
- **Product Requirement Document (PRD)**: [sim-del/prd.md](./sim-del/prd.md)
- **Spesifikasi Teknologi (Tech Stack)**: [sim-del/tech-stack.md](./sim-del/tech-stack.md)
- **Design System ("Warm & Classy Academic")**: [sim-del/design.md](./sim-del/design.md)
- **Skema Database & RESTful Contract**: [sim-del/schema.md](./sim-del/schema.md)
- **Task Backlog & Progress Tracker**: [sim-del/todo.md](./sim-del/todo.md)

---

## 🎨 Frontend & Animation Features (Anime.js v4 + Tailwind CSS)

- **Warm & Classy Academic Aesthetic**: Perpaduan palet warna Del Midnight (`#1E1A28`), Deep Plum (`#312052`), Ivory Parchment (`#FAF8F5`), dan Warm Amber (`#B45309`).
- **Anime.js v4 Orchestrated Micro-Interactions**:
  - **Metric Count-Up Counters**: Angka statistik beranimasi naik secara dinamis saat halaman dimuat.
  - **Staggered Cascade Entrance**: Entri tabel dan kartu monograf masuk berurutan dengan animasi easing halus.
  - **Table vs Grid 3D Tome Switcher**: Pengguna dapat beralih tampilan antara tabel bibliografi dan grid buku 3D tome dengan transisi animasi.
  - **Real-Time Live Monograph Preview**: Form Tambah dan Edit buku menampilkan kartu visual 3D monograf yang diperbarui secara langsung saat pengguna mengetik.
  - **Floating Flash Alert Pop-In**: Pesan feedback toast beranimasi dengan efek pop dan auto-dismiss.
  - **Interactive ISBN Copy**: Tombol salin ISBN dengan feedback animasi ikon dan tooltip.
  - **Global Hotkey**: Tekan tombol `/` pada keyboard untuk langsung fokus ke kolom pencarian katalog.

---

## 🚀 Cara Menjalankan Aplikasi

> **Catatan Penting mengenai Port**:
> - Server web Laravel diakses pada **[http://localhost:8000](http://localhost:8000)**.
> - Port `5173` adalah Vite HMR (Hot Module Replacement) asset bundler, bukan server backend PHP.

### 1. Jalankan Backend Laravel:
```powershell
cd sim-del
php artisan serve
```

### 2. (Opsional untuk Development) Jalankan Vite Dev Server:
```powershell
cd sim-del
npm run dev
```

Atau untuk build produksi tanpa perlu menjalankan Vite:
```powershell
cd sim-del
npm run build
```

Buka peramban di: **[http://localhost:8000](http://localhost:8000)**
