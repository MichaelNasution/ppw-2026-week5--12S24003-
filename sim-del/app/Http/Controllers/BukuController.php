<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource with Eager Loading (Anti N+1) and Pagination.
     */
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // Filter berdasarkan pencarian kata kunci
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->input('kategori_id'));
        }

        $bukus = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('buku.index', compact('bukus', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('buku.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage with strict server-side validation.
     */
    public function store(Request $request)
    {
        $currentYear = date('Y') + 1;

        $validated = $request->validate([
            'isbn' => 'required|digits:13|unique:bukus,isbn',
            'judul' => 'required|string|min:5|max:255',
            'penulis' => 'required|string|max:150',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => "required|integer|digits:4|min:1900|max:{$currentYear}",
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'nullable|string',
        ], [
            'isbn.required' => 'Nomor ISBN wajib diisi.',
            'isbn.digits' => 'Nomor ISBN harus tepat 13 digit angka.',
            'isbn.unique' => 'Nomor ISBN ini sudah terdaftar di sistem.',
            'judul.min' => 'Judul buku minimal harus 5 karakter.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'stok.min' => 'Stok buku tidak boleh bernilai negatif.',
        ]);

        Buku::create($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Buku baru berhasil didaftarkan ke katalog perpustakaan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        $buku->load('kategori');
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        $currentYear = date('Y') + 1;

        $validated = $request->validate([
            'isbn' => [
                'required',
                'digits:13',
                Rule::unique('bukus', 'isbn')->ignore($buku->id),
            ],
            'judul' => 'required|string|min:5|max:255',
            'penulis' => 'required|string|max:150',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => "required|integer|digits:4|min:1900|max:{$currentYear}",
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'nullable|string',
        ], [
            'isbn.digits' => 'Nomor ISBN harus tepat 13 digit angka.',
            'isbn.unique' => 'Nomor ISBN ini sudah terdaftar pada buku lain.',
            'judul.min' => 'Judul buku minimal harus 5 karakter.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'stok.min' => 'Stok buku tidak boleh bernilai negatif.',
        ]);

        $buku->update($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        $judul = $buku->judul;
        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', "Buku '{$judul}' berhasil dihapus dari katalog!");
    }
}

