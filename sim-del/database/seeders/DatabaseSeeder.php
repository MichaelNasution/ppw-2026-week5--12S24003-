<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Pustakawan Uji Resmi (Sesuai Spesifikasi Modul Praktikum Minggu 6)
        User::firstOrCreate(
            ['email' => 'pustakawan@del.ac.id'],
            [
                'name' => 'Pustakawan Utama Del',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Suntikkan Kategori Rumpun Ilmu di IT Del
        $kategoris = [
            ['kode_kategori' => 'INF', 'nama_kategori' => 'Informatika & Ilmu Komputer'],
            ['kode_kategori' => 'RPL', 'nama_kategori' => 'Rekayasa Perangkat Lunak'],
            ['kode_kategori' => 'SI',  'nama_kategori' => 'Sistem Informasi & Bisnis Digital'],
            ['kode_kategori' => 'TE',  'nama_kategori' => 'Teknik Elektro & Sistem Kendali'],
            ['kode_kategori' => 'MAT', 'nama_kategori' => 'Sains Dasar & Matematika Terapan'],
            ['kode_kategori' => 'BIO', 'nama_kategori' => 'Bioteknologi & Rekayasa Hayati'],
        ];

        $kategoriModels = [];
        foreach ($kategoris as $item) {
            $kategoriModels[$item['kode_kategori']] = Kategori::firstOrCreate(
                ['kode_kategori' => $item['kode_kategori']],
                ['nama_kategori' => $item['nama_kategori']]
            );
        }

        // 3. Suntikkan Koleksi Buku Lengkap (Termasuk Spesimen Stok = 0 dan Stok = 1 untuk Pengujian ACID)
        $koleksiBuku = [
            // Sampel Buku Uji Stok = 0 (Khusus Pengujian Rollback Transaksi ACID saat Stok Habis)
            [
                'isbn' => '9786230134567',
                'judul' => 'Tata Kelola Teknologi Informasi & Framework COBIT 2019 (Stok = 0)',
                'penulis' => 'ISACA Research Team',
                'penerbit' => 'Salemba Infotek',
                'tahun_terbit' => 2023,
                'kode_kat' => 'SI',
                'stok' => 0, // STOK = 0 (WAJIB DITOLAK & ROLLBACK)
                'sinopsis' => 'Buku uji coba khusus pengujian transaksi ACID: Ketika stok bernilai 0, sistem wajib menolak peminjaman secara atomik dan tidak mengizinkan nilai stok menjadi minus.',
            ],

            // Sampel Buku Uji Stok = 1 (Khusus Pengujian Concurrency Locking lockForUpdate)
            [
                'isbn' => '9786020638294',
                'judul' => 'Kriptografi Kuantum & Keamanan Blockchain (Stok = 1)',
                'penulis' => 'Dr. Ing. Kripto Del',
                'penerbit' => 'Del Press',
                'tahun_terbit' => 2024,
                'kode_kat' => 'INF',
                'stok' => 1, // STOK = 1 (PENGUJIAN REBUTAN KUOTA / PESSIMISTIC LOCKING)
                'sinopsis' => 'Spesimen pengujian concurrency locking: Jika dua transaksi mencoba meminjam pada saat bersamaan, lockForUpdate memastikan hanya pemohon pertama yang lolos dan pemohon kedua ditolak setelah stok menjadi 0.',
            ],

            // Buku-Buku Koleksi Umum
            [
                'isbn' => '9780078022128',
                'judul' => 'Clean Code: Panduan Menulis Kode Bersih dan Teruji',
                'penulis' => 'Robert C. Martin',
                'penerbit' => 'Prentice Hall',
                'tahun_terbit' => 2021,
                'kode_kat' => 'RPL',
                'stok' => 5,
                'sinopsis' => 'Buku pegangan wajib bagi software engineer untuk menghasilkan kode yang modular, mudah dipelihara, dan menerapkan prinsip-prinsip SOLID secara elegan.',
            ],
            [
                'isbn' => '9786230105432',
                'judul' => 'Dasar Pemrograman Web Modern dengan Laravel 11 & Blade',
                'penulis' => 'Chandro Pardede, S.Kom., M.Sc.',
                'penerbit' => 'IT Del Press',
                'tahun_terbit' => 2024,
                'kode_kat' => 'RPL',
                'stok' => 12,
                'sinopsis' => 'Panduan komprehensif implementasi arsitektur Model-View-Controller (MVC), database persistence, ACID transactions, dan Blade Component Engine.',
            ],
            [
                'isbn' => '9786020385914',
                'judul' => 'Manajemen Basis Data Relasional & Optimasi SQL Tingkat Lanjut',
                'penulis' => 'Abdul Kadir',
                'penerbit' => 'Andi Offset Yogyakarta',
                'tahun_terbit' => 2023,
                'kode_kat' => 'SI',
                'stok' => 7,
                'sinopsis' => 'Menelaah arsitektur internal database engine relasional, transaksi ACID, isolasi level, dan mitigasi N+1 query problem menggunakan Eager Loading.',
            ],
            [
                'isbn' => '9786022987123',
                'judul' => 'Sistem Informasi Manajemen: Perspektif Perusahaan Modern',
                'penulis' => 'Kenneth C. Laudon & Jane P. Laudon',
                'penerbit' => 'Salemba Empat',
                'tahun_terbit' => 2022,
                'kode_kat' => 'SI',
                'stok' => 4,
                'sinopsis' => 'Kajian strategis peranan sistem informasi korporat, ERP, supply chain management, dan transformasi digital.',
            ],
            [
                'isbn' => '9789792965431',
                'judul' => 'Rangkaian Listrik & Elektronika Terapan untuk Teknik',
                'penulis' => 'William H. Hayt & Jack E. Kemmerly',
                'penerbit' => 'Erlangga Akademik',
                'tahun_terbit' => 2020,
                'kode_kat' => 'TE',
                'stok' => 6,
                'sinopsis' => 'Prinsip dasar analisis rangkaian listrik DC dan AC, teorema Thevenin dan Norton, serta respon transien rangkaian orde satu dan dua.',
            ],
            [
                'isbn' => '9786024462198',
                'judul' => 'Sistem Kendali Kontinyu & Robotika Otonom Berbasis ROS',
                'penulis' => 'Katsuhiko Ogata',
                'penerbit' => 'Prentice Hall',
                'tahun_terbit' => 2021,
                'kode_kat' => 'TE',
                'stok' => 3,
                'sinopsis' => 'Teori kontrol klasik dan modern, pemodelan fungsi alih, kestabilan Routh-Hurwitz, dan implementasi robotika otonom.',
            ],
            [
                'isbn' => '9789790158921',
                'judul' => 'Kalkulus Diferensial & Integral Peubah Banyak',
                'penulis' => 'James Stewart',
                'penerbit' => 'Salemba Teknika',
                'tahun_terbit' => 2022,
                'kode_kat' => 'MAT',
                'stok' => 10,
                'sinopsis' => 'Buku teks standar universitas yang memuat materi limit, turunan parsial, integral lipat dua dan tiga, serta kalkulus vektor.',
            ],
            [
                'isbn' => '9786021514782',
                'judul' => 'Matematika Diskrit dan Teori Graf untuk Informatika',
                'penulis' => 'Rinaldi Munir, M.T.',
                'penerbit' => 'Penerbit Informatika Bandung',
                'tahun_terbit' => 2023,
                'kode_kat' => 'MAT',
                'stok' => 9,
                'sinopsis' => 'Membahas logika proposisi, relasi dan fungsi, kombinatorika, aljabar Boolean, dan struktur pohon (tree).',
            ],
            [
                'isbn' => '9786232091234',
                'judul' => 'Pengantar Bioteknologi Molekuler & Rekayasa Genetika',
                'penulis' => 'Bernard R. Glick & Cheryl L. Patten',
                'penerbit' => 'Deepublish',
                'tahun_terbit' => 2021,
                'kode_kat' => 'BIO',
                'stok' => 4,
                'sinopsis' => 'Konsep dasar manipulasi DNA rekombinan, kloning gen, teknologi CRISPR-Cas9, dan aplikasi bioteknologi pada agrikultur.',
            ],
        ];

        $bukuInstances = [];
        foreach ($koleksiBuku as $bukuData) {
            $kat = $kategoriModels[$bukuData['kode_kat']] ?? reset($kategoriModels);

            $bukuInstances[] = Buku::firstOrCreate(
                ['isbn' => $bukuData['isbn']],
                [
                    'judul' => $bukuData['judul'],
                    'penulis' => $bukuData['penulis'],
                    'penerbit' => $bukuData['penerbit'],
                    'tahun_terbit' => $bukuData['tahun_terbit'],
                    'kategori_id' => $kat->id,
                    'stok' => $bukuData['stok'],
                    'sinopsis' => $bukuData['sinopsis'],
                ]
            );
        }

        // 4. Suntikkan Sampel Riwayat Transaksi Peminjaman (Sesuai Spesifikasi Modul)
        $cleanCodeBuku = Buku::where('isbn', '9780078022128')->first();
        $laravelBuku   = Buku::where('isbn', '9786230105432')->first();
        $dbBuku        = Buku::where('isbn', '9786020385914')->first();

        if ($cleanCodeBuku) {
            // Transaksi 1: Sedang dipinjam (Aktif)
            Peminjaman::firstOrCreate(
                ['kode_pinjam' => 'PJM-20261110-DEL01'],
                [
                    'buku_id' => $cleanCodeBuku->id,
                    'nim_peminjam' => '12S24003',
                    'nama_peminjam' => 'Michael Pratama Nasution',
                    'tanggal_pinjam' => now()->subDays(2)->toDateString(),
                    'tanggal_jatuh_tempo' => now()->addDays(5)->toDateString(),
                    'tanggal_kembali' => null,
                    'status' => 'dipinjam',
                ]
            );
        }

        if ($laravelBuku) {
            // Transaksi 2: Selesai dikembalikan
            Peminjaman::firstOrCreate(
                ['kode_pinjam' => 'PJM-20261101-DEL02'],
                [
                    'buku_id' => $laravelBuku->id,
                    'nim_peminjam' => '12S24010',
                    'nama_peminjam' => 'Maria Simanjuntak',
                    'tanggal_pinjam' => now()->subDays(10)->toDateString(),
                    'tanggal_jatuh_tempo' => now()->subDays(3)->toDateString(),
                    'tanggal_kembali' => now()->subDays(2)->toDateString(),
                    'status' => 'dikembalikan',
                ]
            );
        }

        if ($dbBuku) {
            // Transaksi 3: Pinjaman aktif dengan status lewat tempo (Audit keterlambatan)
            Peminjaman::firstOrCreate(
                ['kode_pinjam' => 'PJM-20261025-DEL03'],
                [
                    'buku_id' => $dbBuku->id,
                    'nim_peminjam' => '12S24025',
                    'nama_peminjam' => 'Budi Santoso',
                    'tanggal_pinjam' => now()->subDays(15)->toDateString(),
                    'tanggal_jatuh_tempo' => now()->subDays(8)->toDateString(),
                    'tanggal_kembali' => null,
                    'status' => 'dipinjam',
                ]
            );
        }
    }
}
