<x-layout title="Transaksi Pinjam Buku">
    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Top Breadcrumb & Header -->
        <div class="pb-4 border-b border-[#E8E1D5]">
            <nav class="flex items-center gap-2 text-xs text-[#7A7265] mb-1 font-medium">
                <a href="{{ route('buku.index') }}" class="hover:text-[#1E1A28] no-underline">Beranda</a>
                <span class="text-xs">&bull;</span>
                <a href="{{ route('peminjaman.index') }}" class="hover:text-[#1E1A28] no-underline">Sirkulasi</a>
                <span class="text-xs">&bull;</span>
                <span class="text-[#2B213A] font-semibold">Transaksi Baru</span>
            </nav>
            <h1 class="text-2xl font-bold tracking-tight text-[#1E1A28] flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[28px] text-[#312052]">library_add</span>
                <span>Form Peminjaman Buku Perpustakaan</span>
            </h1>
            <p class="text-xs text-[#7A7265] mt-1">
                Catat peminjaman koleksi buku ke anggota sivitas akademika Del dengan jaminan integritas data ACID.
            </p>
        </div>

        <!-- ACID & Concurrency Notice Callout -->
        <div class="p-4 rounded-xl bg-[#FAF0E4] border border-[#F3E1C8] flex items-start gap-3 text-xs text-[#9A5B18]">
            <span class="material-symbols-outlined text-[22px] text-[#B4681E] shrink-0">verified_user</span>
            <div class="space-y-1">
                <span class="font-bold text-[#784411] block">Jaminan Integritas Transaksi ACID (Atomicity, Consistency, Isolation, Durability)</span>
                <p class="text-[#844C16] leading-relaxed">
                    Sistem membungkus pengurangan kuota stok dan pembuatan berkas peminjaman dalam <code class="font-mono bg-white/70 px-1 py-0.5 rounded font-semibold text-[#663608]">DB::transaction()</code> serta menerapkan <code class="font-mono bg-white/70 px-1 py-0.5 rounded font-semibold text-[#663608]">lockForUpdate()</code>. Bila stok tersisa 0 atau terjadi konflik ganda, transaksi akan dibatalkan secara atomik (rollback).
                </p>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="card-classy p-6">
            <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Pilih Buku -->
                <div>
                    <label for="buku_id" class="block text-xs font-bold uppercase tracking-wider text-[#554D40] mb-2">
                        Pilih Koleksi Buku <span class="text-red-500">*</span>
                    </label>
                    <select name="buku_id" id="buku_id" class="form-select-classy w-full @error('buku_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Buku dari Katalog Perpustakaan --</option>
                        @foreach($bukus as $item)
                            <option value="{{ $item->id }}" 
                                    data-stok="{{ $item->stok }}"
                                    {{ old('buku_id', $selectedBuku->id ?? '') == $item->id ? 'selected' : '' }}>
                                {{ $item->judul }} (ISBN: {{ $item->isbn }}) — Sisa Stok: {{ $item->stok }} eks
                                @if($item->stok == 0) [HABIS - Rollback Test] @endif
                            </option>
                        @endforeach
                    </select>
                    @error('buku_id')
                        <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- NIM & Nama Mahasiswa -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- NIM -->
                    <div>
                        <label for="nim_peminjam" class="block text-xs font-bold uppercase tracking-wider text-[#554D40] mb-2">
                            NIM Peminjam <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="nim_peminjam" 
                               id="nim_peminjam" 
                               value="{{ old('nim_peminjam') }}" 
                               placeholder="Contoh: 12S24003" 
                               class="form-control-classy w-full uppercase font-mono @error('nim_peminjam') border-red-500 @enderror" 
                               required>
                        @error('nim_peminjam')
                            <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nama Mahasiswa -->
                    <div>
                        <label for="nama_peminjam" class="block text-xs font-bold uppercase tracking-wider text-[#554D40] mb-2">
                            Nama Lengkap Peminjam <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="nama_peminjam" 
                               id="nama_peminjam" 
                               value="{{ old('nama_peminjam') }}" 
                               placeholder="Contoh: Michael Pratama Nasution" 
                               class="form-control-classy w-full @error('nama_peminjam') border-red-500 @enderror" 
                               required>
                        @error('nama_peminjam')
                            <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Durasi Peminjaman -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
                    <div>
                        <label for="durasi_hari" class="block text-xs font-bold uppercase tracking-wider text-[#554D40] mb-2">
                            Durasi Peminjaman (Hari)
                        </label>
                        <select name="durasi_hari" id="durasi_hari" class="form-select-classy w-full">
                            <option value="3" {{ old('durasi_hari') == 3 ? 'selected' : '' }}>3 Hari (Peminjaman Singkat)</option>
                            <option value="7" {{ old('durasi_hari', 7) == 7 ? 'selected' : '' }}>7 Hari (Standar Perpustakaan Del)</option>
                            <option value="14" {{ old('durasi_hari') == 14 ? 'selected' : '' }}>14 Hari (Dua Minggu)</option>
                            <option value="21" {{ old('durasi_hari') == 21 ? 'selected' : '' }}>21 Hari (Tiga Minggu)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#554D40] mb-2">
                            Tanggal Peminjaman Hari Ini
                        </label>
                        <input type="text" 
                               value="{{ now()->translatedFormat('d F Y') }}" 
                               class="form-control-classy w-full bg-[#F5F2EB] text-[#7A7265] font-medium cursor-not-allowed" 
                               readonly>
                    </div>
                </div>

                <!-- Submit & Cancel Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E8E1D5]">
                    <a href="{{ route('peminjaman.index') }}" class="btn-del-outline text-xs px-4 py-2.5 rounded-lg no-underline font-semibold">
                        Batal
                    </a>
                    <button type="submit" class="btn-del inline-flex items-center gap-2 text-xs px-5 py-2.5 rounded-lg font-semibold shadow-sm">
                        <span class="material-symbols-outlined text-[17px]">task_alt</span>
                        <span>Konfirmasi Peminjaman Atomik</span>
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-layout>
