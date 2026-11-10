<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class QueryBuilderAnalyticsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Uji katalog buku menampilkan withCount('peminjamans') dan kartu statistik DB::table.
     */
    public function test_katalog_buku_memuat_statistik_query_builder_dan_with_count(): void
    {
        $kategori = Kategori::firstOrCreate(
            ['kode_kategori' => 'SI'],
            ['nama_kategori' => 'Sistem Informasi', 'deskripsi' => 'Rumpun SI']
        );

        $buku = Buku::create([
            'isbn' => '978' . rand(1000000000, 9999999999),
            'judul' => 'Analisis Perancangan Sistem',
            'penulis' => 'Prof. Sistem',
            'penerbit' => 'Del Press',
            'tahun_terbit' => 2024,
            'kategori_id' => $kategori->id,
            'stok' => 10,
        ]);

        // Buat 1 peminjaman untuk buku ini
        Peminjaman::create([
            'kode_pinjam' => 'PJM-TEST-001',
            'buku_id' => $buku->id,
            'nim_peminjam' => '12S24099',
            'nama_peminjam' => 'Tester Mahasiswa',
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_jatuh_tempo' => now()->addDays(7)->toDateString(),
            'status' => 'dipinjam',
        ]);

        $response = $this->get(route('buku.index'));

        $response->assertStatus(200);
        $response->assertViewHas('stats');
        $response->assertViewHas('bukus');

        $stats = $response->viewData('stats');
        $this->assertArrayHasKey('total_judul', $stats);
        $this->assertArrayHasKey('total_stok', $stats);
        $this->assertArrayHasKey('sedang_dipinjam', $stats);
        $this->assertArrayHasKey('total_dikembalikan', $stats);

        $this->assertGreaterThanOrEqual(1, $stats['total_judul']);
        $this->assertGreaterThanOrEqual(1, $stats['sedang_dipinjam']);

        // Verifikasi filter pencarian dinamis when()
        $responseSearch = $this->get(route('buku.index', ['search' => 'Perancangan']));
        $responseSearch->assertStatus(200);
        $responseSearch->assertSee('Analisis Perancangan Sistem');
    }
}
