<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AcidTransactionTest extends TestCase
{
    use DatabaseTransactions;

    protected Kategori $kategori;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kategori = Kategori::firstOrCreate(
            ['kode_kategori' => 'TI'],
            [
                'nama_kategori' => 'Teknologi Informasi',
                'deskripsi' => 'Buku-buku informatika dan sistem informasi',
            ]
        );
    }

    /**
     * Uji peminjaman buku normal berhasil mengurangi stok secara atomik.
     */
    public function test_peminjaman_buku_berhasil_dan_stok_berkurang_secara_atomik(): void
    {
        $buku = Buku::create([
            'isbn' => '978' . rand(1000000000, 9999999999),
            'judul' => 'Arsitektur Basis Data Modern',
            'penulis' => 'Dr. Arsitek DB',
            'penerbit' => 'Del Press',
            'tahun_terbit' => 2024,
            'kategori_id' => $this->kategori->id,
            'stok' => 5,
        ]);

        $response = $this->post(route('peminjaman.store'), [
            'buku_id' => $buku->id,
            'nim_peminjam' => '12S24003',
            'nama_peminjam' => 'Michael Pratama Nasution',
            'durasi_hari' => 7,
        ]);

        $response->assertRedirect(route('peminjaman.index'));
        $response->assertSessionHas('success');

        // Pastikan stok berkurang dari 5 menjadi 4
        $this->assertEquals(4, $buku->fresh()->stok);

        // Pastikan record tercatat di database
        $this->assertDatabaseHas('peminjamans', [
            'buku_id' => $buku->id,
            'nim_peminjam' => '12S24003',
            'status' => 'dipinjam',
        ]);
    }

    /**
     * Uji prinsip ACID: Peminjaman saat stok = 0 wajib ditolak dan rollback secara atomik (stok tidak boleh negatif).
     */
    public function test_peminjaman_saat_stok_habis_wajib_ditolak_dan_rollback(): void
    {
        $bukuHabis = Buku::create([
            'isbn' => '978' . rand(1000000000, 9999999999),
            'judul' => 'Basis Data Skala Besar (Stok Habis)',
            'penulis' => 'Pakar DB',
            'penerbit' => 'Del Press',
            'tahun_terbit' => 2024,
            'kategori_id' => $this->kategori->id,
            'stok' => 0, // Stok = 0
        ]);

        $response = $this->post(route('peminjaman.store'), [
            'buku_id' => $bukuHabis->id,
            'nim_peminjam' => '12S24003',
            'nama_peminjam' => 'Michael Pratama Nasution',
            'durasi_hari' => 7,
        ]);

        $response->assertSessionHas('error');

        // Stok harus tetap 0 dan tidak boleh minus (-1)
        $this->assertEquals(0, $bukuHabis->fresh()->stok);

        // Tidak boleh ada transaksi baru di tabel peminjamans
        $this->assertDatabaseMissing('peminjamans', [
            'buku_id' => $bukuHabis->id,
            'nim_peminjam' => '12S24003',
        ]);
    }

    /**
     * Uji pencegahan pinjam ganda: NIM yang sama tidak boleh meminjam buku yang sama sebelum dikembalikan.
     */
    public function test_nim_yang_sama_tidak_bisa_meminjam_buku_yang_sama_dua_kali(): void
    {
        $buku = Buku::create([
            'isbn' => '978' . rand(1000000000, 9999999999),
            'judul' => 'Algoritma & Struktur Data',
            'penulis' => 'Dosen Del',
            'penerbit' => 'Del Press',
            'tahun_terbit' => 2024,
            'kategori_id' => $this->kategori->id,
            'stok' => 3,
        ]);

        // Pinjaman pertama berhasil
        $this->post(route('peminjaman.store'), [
            'buku_id' => $buku->id,
            'nim_peminjam' => '12S24003',
            'nama_peminjam' => 'Michael Pratama Nasution',
            'durasi_hari' => 7,
        ]);

        $this->assertEquals(2, $buku->fresh()->stok);

        // Pinjaman kedua dengan NIM sama untuk buku yang sama harus ditolak
        $response = $this->post(route('peminjaman.store'), [
            'buku_id' => $buku->id,
            'nim_peminjam' => '12S24003',
            'nama_peminjam' => 'Michael Pratama Nasution',
            'durasi_hari' => 7,
        ]);

        $response->assertSessionHas('error');

        // Stok tidak boleh berkurang lagi (tetap 2)
        $this->assertEquals(2, $buku->fresh()->stok);
    }

    /**
     * Uji pengembalian buku memulihkan stok atomik dan mengubah status jadi 'dikembalikan'.
     */
    public function test_pengembalian_buku_mengembalikan_stok_secara_atomik(): void
    {
        $buku = Buku::create([
            'isbn' => '978' . rand(1000000000, 9999999999),
            'judul' => 'Pemrograman Web Lanjut',
            'penulis' => 'Chandro Pardede',
            'penerbit' => 'Del Press',
            'tahun_terbit' => 2024,
            'kategori_id' => $this->kategori->id,
            'stok' => 2,
        ]);

        // Pinjam buku
        $this->post(route('peminjaman.store'), [
            'buku_id' => $buku->id,
            'nim_peminjam' => '12S24003',
            'nama_peminjam' => 'Michael Pratama Nasution',
            'durasi_hari' => 7,
        ]);

        $this->assertEquals(1, $buku->fresh()->stok);

        $pinjam = Peminjaman::where('buku_id', $buku->id)->first();

        // Kembalikan buku
        $response = $this->patch(route('peminjaman.kembali', $pinjam->id));
        $response->assertSessionHas('success');

        // Pastikan status jadi 'dikembalikan' dan tanggal kembali terisi
        $pinjamFresh = $pinjam->fresh();
        $this->assertEquals('dikembalikan', $pinjamFresh->status);
        $this->assertNotNull($pinjamFresh->tanggal_kembali);

        // Pastikan stok dipulihkan kembali ke 2
        $this->assertEquals(2, $buku->fresh()->stok);
    }
}
