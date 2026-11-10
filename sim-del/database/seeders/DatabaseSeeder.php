<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Suntikkan minimal 5 Kategori Rumpun Ilmu di IT Del
        $kategoris = [
            [
                'kode_kategori' => 'INF',
                'nama_kategori' => 'Informatika & Ilmu Komputer',
            ],
            [
                'kode_kategori' => 'RPL',
                'nama_kategori' => 'Rekayasa Perangkat Lunak',
            ],
            [
                'kode_kategori' => 'SI',
                'nama_kategori' => 'Sistem Informasi & Bisnis Digital',
            ],
            [
                'kode_kategori' => 'TE',
                'nama_kategori' => 'Teknik Elektro & Sistem Kendali',
            ],
            [
                'kode_kategori' => 'MAT',
                'nama_kategori' => 'Sains Dasar & Matematika Terapan',
            ],
            [
                'kode_kategori' => 'BIO',
                'nama_kategori' => 'Bioteknologi & Rekayasa Hayati',
            ],
        ];

        $kategoriModels = [];
        foreach ($kategoris as $item) {
            $kategoriModels[] = Kategori::firstOrCreate(
                ['kode_kategori' => $item['kode_kategori']],
                ['nama_kategori' => $item['nama_kategori']]
            );
        }

        // 2. Suntikkan minimal 20 Koleksi Buku Realistis
        $koleksiBuku = [
            [
                'isbn' => '9786020638294',
                'judul' => 'Struktur Data & Algoritma Lanjut dengan Python',
                'penulis' => 'Rinaldi Munir, M.T.',
                'penerbit' => 'Penerbit Informatika Bandung',
                'tahun_terbit' => 2022,
                'kode_kat' => 'INF',
                'stok' => 8,
                'sinopsis' => 'Buku ini membahas konsep fundamental hingga tingkat lanjut struktur data linear dan non-linear, analisis kompleksitas asimtotik algoritma (Big-O notation), serta implementasi grafis menggunakan bahasa pemrograman Python 3.',
            ],
            [
                'isbn' => '9780078022128',
                'judul' => 'Clean Code: Panduan Menulis Kode Bersih dan Teruji',
                'penulis' => 'Robert C. Martin',
                'penerbit' => 'Prentice Hall',
                'tahun_terbit' => 2021,
                'kode_kat' => 'RPL',
                'stok' => 5,
                'sinopsis' => 'Buku pegangan wajib bagi software engineer untuk menghasilkan kode yang mudah dipelihara, modular, memiliki tingkat keterbacaan tinggi, serta menerapkan prinsip-prinsip SOLID secara elegan.',
            ],
            [
                'isbn' => '9786230105432',
                'judul' => 'Dasar Pemrograman Web Modern dengan Laravel 11 & Blade',
                'penulis' => 'Chandro Pardede, S.Kom., M.Sc.',
                'penerbit' => 'IT Del Press',
                'tahun_terbit' => 2024,
                'kode_kat' => 'RPL',
                'stok' => 12,
                'sinopsis' => 'Panduan komprehensif implementasi arsitektur Model-View-Controller (MVC), Request Lifecycle, migrasi database, Eloquent ORM, dan Blade Component Engine pada framework Laravel modern.',
            ],
            [
                'isbn' => '9786020385914',
                'judul' => 'Manajemen Basis Data Relasional & Optimasi SQL Tingkat Lanjut',
                'penulis' => 'Abdul Kadir',
                'penerbit' => 'Andi Offset Yogyakarta',
                'tahun_terbit' => 2023,
                'kode_kat' => 'SI',
                'stok' => 7,
                'sinopsis' => 'Menelaah arsitektur internal database engine relasional, normalisasi data 1NF hingga BCNF, teknik indexing B-Tree, serta mitigasi query bottleneck dan N+1 query problem.',
            ],
            [
                'isbn' => '9786022987123',
                'judul' => 'Sistem Informasi Manajemen: Perspektif Perusahaan Modern',
                'penulis' => 'Kenneth C. Laudon & Jane P. Laudon',
                'penerbit' => 'Salemba Empat',
                'tahun_terbit' => 2022,
                'kode_kat' => 'SI',
                'stok' => 4,
                'sinopsis' => 'Kajian strategis peranan sistem informasi korporat, ERP, supply chain management, dan transformasi digital dalam memenangkan kompetisi bisnis global.',
            ],
            [
                'isbn' => '9789792965431',
                'judul' => 'Rangkaian Listrik & Elektronika Terapan untuk Teknik',
                'penulis' => 'William H. Hayt & Jack E. Kemmerly',
                'penerbit' => 'Erlangga Akademik',
                'tahun_terbit' => 2020,
                'kode_kat' => 'TE',
                'stok' => 6,
                'sinopsis' => 'Prinsip dasar analisis rangkaian listrik DC dan AC, teorema Thevenin dan Norton, respon transien orde satu dan dua, serta pengantar komponen semikonduktor.',
            ],
            [
                'isbn' => '9786024462198',
                'judul' => 'Sistem Kendali Kontinyu & Robotika Otonom Berbasis ROS',
                'penulis' => 'Katsuhiko Ogata',
                'penerbit' => 'Prentice Hall',
                'tahun_terbit' => 2021,
                'kode_kat' => 'TE',
                'stok' => 3,
                'sinopsis' => 'Teori kontrol klasik dan modern, pemodelan fungsi alih, kestabilan Routh-Hurwitz, root locus, diagram Bode, serta penerapannya pada robotika bergerak.',
            ],
            [
                'isbn' => '9789790158921',
                'judul' => 'Kalkulus Diferensial & Integral Peubah Banyak',
                'penulis' => 'James Stewart',
                'penerbit' => 'Salemba Teknika',
                'tahun_terbit' => 2022,
                'kode_kat' => 'MAT',
                'stok' => 10,
                'sinopsis' => 'Buku teks standar universitas yang memuat materi limit, turunan parsial, integral lipat dua dan tiga, kalkulus vektor, teorema Green, Gauss, dan Stokes.',
            ],
            [
                'isbn' => '9786021514782',
                'judul' => 'Matematika Diskrit dan Teori Graf untuk Informatika',
                'penulis' => 'Rinaldi Munir, M.T.',
                'penerbit' => 'Penerbit Informatika Bandung',
                'tahun_terbit' => 2023,
                'kode_kat' => 'MAT',
                'stok' => 9,
                'sinopsis' => 'Membahas logika proposisi, teori himpunan, relasi dan fungsi, kombinatorika, relasi rekurens, aljabar Boolean, teori graf, dan struktur pohon (tree).',
            ],
            [
                'isbn' => '9786232091234',
                'judul' => 'Pengantar Bioteknologi Molekuler & Rekayasa Genetika',
                'penulis' => 'Bernard R. Glick & Cheryl L. Patten',
                'penerbit' => 'Deepublish',
                'tahun_terbit' => 2021,
                'kode_kat' => 'BIO',
                'stok' => 4,
                'sinopsis' => 'Konsep dasar manipulasi DNA rekombinan, kloning gen, ekspresi protein rekombinan, teknologi CRISPR-Cas9, dan aplikasi bioteknologi pada agrikultur dan kesehatan.',
            ],
            [
                'isbn' => '9786026232987',
                'judul' => 'Rekayasa Kebutuhan Perangkat Lunak Berbasis Agile',
                'penulis' => 'Ian Sommerville',
                'penerbit' => 'Pearson Education',
                'tahun_terbit' => 2023,
                'kode_kat' => 'RPL',
                'stok' => 6,
                'sinopsis' => 'Metodologi elisitasi, analisis, spesifikasi, dan validasi requirement sistem perangkat lunak berskala enterprise menggunakan pendekatan User Stories dan Scrum.',
            ],
            [
                'isbn' => '9786230118942',
                'judul' => 'Machine Learning & Deep Learning Terapan dengan PyTorch',
                'penulis' => 'Aurélien Géron',
                'penerbit' => 'O\'Reilly Media',
                'tahun_terbit' => 2024,
                'kode_kat' => 'INF',
                'stok' => 7,
                'sinopsis' => 'Panduan praktis membangun model klasifikasi, regresi, Convolutional Neural Networks (CNN), dan Recurrent Neural Networks (RNN) untuk analisis big data.',
            ],
            [
                'isbn' => '9786022806541',
                'judul' => 'Keamanan Jaringan Komputer, Kriptografi & Ethical Hacking',
                'penulis' => 'William Stallings',
                'penerbit' => 'Andi Publisher',
                'tahun_terbit' => 2022,
                'kode_kat' => 'INF',
                'stok' => 5,
                'sinopsis' => 'Prinsip keamanan informasi CIA triad, algoritma kriptografi simetris AES dan asimetris RSA, sertifikat digital PKI, firewall, dan mitigasi serangan cyber.',
            ],
            [
                'isbn' => '9786020311239',
                'judul' => 'Analisis dan Perancangan Sistem Informasi Menggunakan UML',
                'penulis' => 'Rosa A.S. & M. Shalahuddin',
                'penerbit' => 'Informatika Bandung',
                'tahun_terbit' => 2021,
                'kode_kat' => 'SI',
                'stok' => 8,
                'sinopsis' => 'Panduan terstruktur perancangan sistem berorientasi objek menggunakan diagram Use Case, Activity, Class, Sequence, dan Deployment Diagram.',
            ],
            [
                'isbn' => '9786021514999',
                'judul' => 'Sistem Tertanam (Embedded System) Berbasis Mikrokontroler ARM Cortex-M',
                'penulis' => 'Agus Bejo',
                'penerbit' => 'Graha Ilmu',
                'tahun_terbit' => 2022,
                'kode_kat' => 'TE',
                'stok' => 5,
                'sinopsis' => 'Perancangan hardware dan software sistem benam, komunikasi serial I2C, SPI, UART, interfacing sensor analog-digital, dan pemrograman bare-metal C.',
            ],
            [
                'isbn' => '9786024461023',
                'judul' => 'Aljabar Linier Terapan untuk Sains Data dan Kecerdasan Buatan',
                'penulis' => 'Gilbert Strang',
                'penerbit' => 'Wellesley-Cambridge Press',
                'tahun_terbit' => 2023,
                'kode_kat' => 'MAT',
                'stok' => 6,
                'sinopsis' => 'Vektor, ruang vektor, transformasi linear, nilai eigen dan vektor eigen, dekomposisi nilai singular (SVD), dan reduksi dimensi Principal Component Analysis (PCA).',
            ],
            [
                'isbn' => '9786230123456',
                'judul' => 'Pengujian Perangkat Lunak & Otomasi QA Berbasis Selenium dan Pest',
                'penulis' => 'Glenford J. Myers',
                'penerbit' => 'Wiley Academic',
                'tahun_terbit' => 2024,
                'kode_kat' => 'RPL',
                'stok' => 4,
                'sinopsis' => 'Strategi black-box dan white-box testing, unit testing otomatis, integrasi pengujian continuous integration (CI/CD), dan pelaporan bug audit.',
            ],
            [
                'isbn' => '9786020456789',
                'judul' => 'Arsitektur Microservices & Cloud Native dengan Docker dan Kubernetes',
                'penulis' => 'Sam Newman',
                'penerbit' => 'O\'Reilly Media',
                'tahun_terbit' => 2023,
                'kode_kat' => 'INF',
                'stok' => 5,
                'sinopsis' => 'Mendekomposisi sistem monolitik menjadi layanan independen, orkestrasi kontainer dengan Kubernetes, API Gateway, dan monitoring terdistribusi.',
            ],
            [
                'isbn' => '9786023751234',
                'judul' => 'Bioinformatika & Analisis Data Genomik Berbasis Komputasi',
                'penulis' => 'Arthur M. Lesk',
                'penerbit' => 'Oxford University Press',
                'tahun_terbit' => 2022,
                'kode_kat' => 'BIO',
                'stok' => 3,
                'sinopsis' => 'Pencarian homologi sekuens DNA dan protein menggunakan BLAST, penyejajaran sekuens ganda (multiple sequence alignment), dan prediksi struktur protein.',
            ],
            [
                'isbn' => '9786230134567',
                'judul' => 'Tata Kelola Teknologi Informasi & Framework COBIT 2019',
                'penulis' => 'ISACA Research Team',
                'penerbit' => 'Salemba Infotek',
                'tahun_terbit' => 2023,
                'kode_kat' => 'SI',
                'stok' => 0, // Sengaja diset 0 untuk menguji indikator "Stok Habis"
                'sinopsis' => 'Prinsip tata kelola teknologi informasi institusi, manajemen risiko kepatuhan, audit sistem informasi, dan penyelarasan tujuan TI dengan tujuan bisnis.',
            ],
        ];

        foreach ($koleksiBuku as $bukuData) {
            $kat = Kategori::where('kode_kategori', $bukuData['kode_kat'])->first();

            Buku::firstOrCreate(
                ['isbn' => $bukuData['isbn']],
                [
                    'judul' => $bukuData['judul'],
                    'penulis' => $bukuData['penulis'],
                    'penerbit' => $bukuData['penerbit'],
                    'tahun_terbit' => $bukuData['tahun_terbit'],
                    'kategori_id' => $kat ? $kat->id : $kategoriModels[0]->id,
                    'stok' => $bukuData['stok'],
                    'sinopsis' => $bukuData['sinopsis'],
                ]
            );
        }
    }
}
