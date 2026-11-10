<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar riwayat sirkulasi peminjaman buku.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with('buku.kategori');

        // Filter berdasarkan status transaksi
        if ($request->filled('status') && in_array($request->status, ['dipinjam', 'dikembalikan'])) {
            $query->where('status', $request->status);
        }

        // Filter pencarian berdasarkan kata kunci (NIM, Nama Peminjam, Kode Pinjam, Judul Buku)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('kode_pinjam', 'like', "%{$search}%")
                  ->orWhere('nim_peminjam', 'like', "%{$search}%")
                  ->orWhere('nama_peminjam', 'like', "%{$search}%")
                  ->orWhereHas('buku', function ($sub) use ($search) {
                      $sub->where('judul', 'like', "%{$search}%")
                          ->orWhere('isbn', 'like', "%{$search}%");
                  });
            });
        }

        $peminjamans = $query->latest('id')->paginate(10)->withQueryString();

        return view('peminjaman.index', compact('peminjamans'));
    }

    /**
     * Menampilkan form peminjaman buku baru.
     */
    public function create(Request $request)
    {
        $selectedBukuId = $request->query('buku_id');
        $selectedBuku = null;

        if ($selectedBukuId) {
            $selectedBuku = Buku::find($selectedBukuId);
        }

        $bukus = Buku::with('kategori')
            ->orderBy('judul')
            ->get();

        return view('peminjaman.create', compact('bukus', 'selectedBuku'));
    }

    /**
     * Memproses peminjaman buku dengan transaksi ACID dan Pessimistic Locking (lockForUpdate).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'nim_peminjam' => 'required|string|min:6|max:15',
            'nama_peminjam' => 'required|string|min:3|max:150',
            'durasi_hari' => 'nullable|integer|min:1|max:30',
        ], [
            'buku_id.required' => 'Pilihlah salah satu buku yang akan dipinjam.',
            'buku_id.exists' => 'Buku yang dipilih tidak terdaftar di sistem.',
            'nim_peminjam.required' => 'NIM mahasiswa peminjam wajib diisi.',
            'nim_peminjam.min' => 'NIM minimal harus 6 karakter.',
            'nama_peminjam.required' => 'Nama mahasiswa peminjam wajib diisi.',
        ]);

        try {
            $peminjaman = DB::transaction(function () use ($validated, $request) {
                $bukuId = $validated['buku_id'];
                $nim = strtoupper(trim($validated['nim_peminjam']));
                $nama = trim($validated['nama_peminjam']);
                $durasi = (int) ($request->input('durasi_hari') ?: 7);

                // 1. Lock baris buku dengan SELECT ... FOR UPDATE
                $buku = Buku::where('id', $bukuId)->lockForUpdate()->firstOrFail();

                // 2. Pemeriksaan stok buku (ACID Consistency & Rollback)
                if ($buku->stok < 1) {
                    throw new \RuntimeException("Stok buku '{$buku->judul}' habis (stok = 0). Transaksi peminjaman ditolak.");
                }

                // 3. Cegah NIM yang sama meminjam buku yang sama jika belum dikembalikan
                $pinjamanAktif = Peminjaman::where('buku_id', $buku->id)
                    ->where('nim_peminjam', $nim)
                    ->where('status', 'dipinjam')
                    ->lockForUpdate()
                    ->exists();

                if ($pinjamanAktif) {
                    throw new \RuntimeException("Mahasiswa NIM {$nim} masih memiliki pinjaman aktif untuk buku '{$buku->judul}'. Harap kembalikan buku terlebih dahulu!");
                }

                // 4. Pengurangan stok atomik
                $buku->decrement('stok');

                // 5. Generate kode unik transaksi
                $kodePinjam = 'PJM-' . date('Ymd') . '-' . strtoupper(Str::random(6));

                // 6. Catat record peminjaman ke tabel peminjamans
                return Peminjaman::create([
                    'kode_pinjam' => $kodePinjam,
                    'buku_id' => $buku->id,
                    'nim_peminjam' => $nim,
                    'nama_peminjam' => $nama,
                    'tanggal_pinjam' => now()->toDateString(),
                    'tanggal_jatuh_tempo' => now()->addDays($durasi)->toDateString(),
                    'status' => 'dipinjam',
                ]);
            }, 3);

            return redirect()->route('peminjaman.index')
                ->with('success', "Transaksi peminjaman [{$peminjaman->kode_pinjam}] berhasil diproses secara atomik!");
        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            Log::error('[DATABASE TRANSACTION EXCEPTION - PEMINJAMAN]: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withInput()->with('error', 'Terjadi anomali pada database saat memproses transaksi peminjaman.');
        }
    }

    /**
     * Memproses pengembalian buku dengan transaksi ACID dan pengembalian stok atomik.
     */
    public function kembali(Request $request, int $id)
    {
        try {
            $peminjaman = DB::transaction(function () use ($id) {
                // 1. Lock transaksi peminjaman
                $pinjam = Peminjaman::where('id', $id)->lockForUpdate()->firstOrFail();

                if ($pinjam->status === 'dikembalikan') {
                    throw new \RuntimeException("Transaksi peminjaman #{$pinjam->kode_pinjam} sudah pernah dikembalikan sebelumnya.");
                }

                // 2. Lock baris buku terkait
                $buku = Buku::where('id', $pinjam->buku_id)->lockForUpdate()->firstOrFail();

                // 3. Update status menjadi dikembalikan & isi tanggal_kembali
                $pinjam->update([
                    'status' => 'dikembalikan',
                    'tanggal_kembali' => now()->toDateString(),
                ]);

                // 4. Kembalikan stok buku secara atomik
                $buku->increment('stok');

                return $pinjam;
            }, 3);

            return back()->with('success', "Buku pada transaksi [{$peminjaman->kode_pinjam}] berhasil dikembalikan, stok buku dipulihkan!");
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            Log::error('[DATABASE TRANSACTION EXCEPTION - PENGEMBALIAN]: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Gagal memproses pengembalian buku karena kesalahan pada basis data.');
        }
    }
}
