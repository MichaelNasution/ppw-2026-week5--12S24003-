<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kategori>
 */
class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            ['kode' => 'INF', 'nama' => 'Informatika & Komputasi'],
            ['kode' => 'RPL', 'nama' => 'Rekayasa Perangkat Lunak'],
            ['kode' => 'SI', 'nama' => 'Sistem Informasi & Bisnis Digital'],
            ['kode' => 'TE', 'nama' => 'Teknik Elektro & Robotika'],
            ['kode' => 'MAT', 'nama' => 'Matematika & Sains Terapan'],
            ['kode' => 'BIO', 'nama' => 'Bioteknologi & Rekayasa Hayati'],
            ['kode' => 'MAN', 'nama' => 'Manajemen Rekayasa'],
        ];

        $choice = fake()->unique()->randomElement($categories);

        return [
            'kode_kategori' => $choice['kode'],
            'nama_kategori' => $choice['nama'],
        ];
    }
}
