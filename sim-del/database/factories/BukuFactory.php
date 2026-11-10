<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    protected $model = Buku::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bookTitles = [
            'Struktur Data & Algoritma Lanjut dengan Python',
            'Prinsip Desain Arsitektur Perangkat Lunak Modern',
            'Clean Architecture: Panduan Praktisi Rekayasa Sistem',
            'Rekayasa Kebutuhan Perangkat Lunak Berbasis Agile',
            'Dasar-Dasar Pemrograman Web Berbasis Laravel dan Vue',
            'Kecerdasan Buatan & Pembelajaran Mesin untuk Pemula',
            'Basis Data Relasional & Desain Skema Berkinerja Tinggi',
            'Jaringan Komputer & Keamanan Siber Institusi',
            'Matematika Diskrit untuk Ilmu Komputer & Rekayasa',
            'Metode Penelitian Ilmiah Bidang Teknologi Informasi',
            'Interaksi Manusia dan Komputer: Teori & Implementasi UX',
            'Sistem Tertanam & Pemrograman Mikrokontroler ARM',
            'Analisis & Perancangan Sistem Informasi Perusahaan',
            'Pengantar Sains Data & Analitika Prediktif',
            'Cloud Computing & Arsitektur Microservices Terdistribusi',
            'Pengujian Perangkat Lunak & Otomasi QA Berbasis Test-Driven',
            'Etika Profesi & Hukum Siber di Era Digital',
            'Pemrograman Berorientasi Objek dengan Java & Pola Desain',
            'Keamanan Jaringan & Kriptografi Modern Terapan',
            'Pengolahan Citra Digital & Visi Komputer Menggunakan OpenCV',
            'Pengembangan Aplikasi Mobile dengan Flutter & Dart',
            'Manajemen Proyek TI Berdasarkan Standar PMBOK & Scrum',
        ];

        $publishers = [
            'IT Del Press',
            'Penerbit Informatika Bandung',
            'Andi Offset Yogyakarta',
            'Erlangga Akademik',
            'Salemba Infotek',
            'Gava Media',
            'Deepublish',
        ];

        return [
            'isbn' => fake()->unique()->numerify('978##########'),
            'judul' => fake()->randomElement($bookTitles) . ' (Edisi ' . fake()->numberBetween(1, 4) . ')',
            'penulis' => fake()->name(),
            'penerbit' => fake()->randomElement($publishers),
            'tahun_terbit' => fake()->numberBetween(2018, 2026),
            'kategori_id' => Kategori::inRandomOrder()->first()?->id ?? Kategori::factory(),
            'stok' => fake()->numberBetween(0, 15),
            'sinopsis' => fake()->paragraph(4),
        ];
    }
}

