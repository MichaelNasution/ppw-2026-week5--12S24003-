<x-layout title="Edit Buku">
    <div class="flex flex-col gap-6">

        <!-- Breadcrumb & Top Bar -->
        <nav class="flex items-center gap-2 text-[13px] text-[#78716C]">
            <a class="hover:text-[#312052] transition-colors flex items-center gap-1.5 font-medium text-[#78716C] no-underline" href="{{ url('/buku') }}">
                <span class="material-symbols-outlined text-[17px] text-[#B4681E]">arrow_back</span>
                <span>Katalog Buku</span>
            </a>
            <span class="text-[#CBC4CF] font-mono text-[11px]">/</span>
            <span class="text-[#312052] font-semibold px-2.5 py-0.5 rounded-full bg-[#EAE1DA]">
                Edit: {{ Str::limit($buku->judul ?? 'Monograf', 30) }}
            </span>
        </nav>

        <!-- Header Section -->
        <div class="relative overflow-hidden rounded-2xl bg-[#F6ECE6] border border-[#E8E1D5] p-6 sm:p-8 shadow-sm">
            <div class="relative z-10 max-w-2xl space-y-2">
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-[#312052] text-white text-[11px] font-semibold tracking-wider uppercase font-mono">
                    <span class="material-symbols-outlined text-[15px] text-[#F2C58F]">edit_square</span>
                    <span>Pembaruan Bibliografi</span>
                </div>
                <h1 class="text-[26px] sm:text-[30px] font-bold text-[#1E1A28] tracking-tight leading-tight">
                    Edit Data Monograf Buku
                </h1>
                <p class="text-[14px] text-[#5C5449] leading-relaxed">
                    Perbarui rincian informasi bibliografi, penyesuaian kategori, atau mutasi sisa eksemplar fisik di rak perpustakaan.
                </p>
            </div>
        </div>

        <!-- 2-Column Responsive Layout: Left Form (8 cols) & Right Live Preview (4 cols) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Form Fields (Col 8) -->
            <div class="lg:col-span-8 flex flex-col gap-6">

                <!-- Validation Notice -->
                <div class="p-4 rounded-xl bg-[#FAF7F2] border border-[#E8E1D5] flex items-start gap-3">
                    <span class="material-symbols-outlined text-[#B4681E] text-[22px] mt-0.5">policy</span>
                    <div class="text-[13px] text-[#5C5449]">
                        <strong class="text-[#1E1A28]">Ketentuan Server-Side Guard:</strong>
                        ISBN wajib 13 digit angka unik (kecuali ISBN buku ini), judul minimal 5 karakter, kategori wajib dipilih, dan stok non-negatif (&ge; 0).
                    </div>
                </div>

                <!-- Form Card -->
                <div class="card-classy p-6 sm:p-8">
                    <form action="{{ url('/buku/' . ($buku->id ?? '')) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- ISBN -->
                            <div>
                                <label for="isbn" class="block text-[12px] font-bold text-[#231D2D] uppercase tracking-wider mb-2 font-mono">
                                    Nomor ISBN (13 Digit) <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="isbn" 
                                       id="isbn" 
                                       value="{{ old('isbn', $buku->isbn ?? '') }}"
                                       placeholder="Contoh: 9786020638294" 
                                       maxlength="13"
                                       class="w-full form-control-classy font-mono @error('isbn') border-red-500 bg-red-50/30 @enderror"
                                       required>
                                <p class="text-[11px] text-[#78716C] mt-1.5 font-mono">Eksak 13 karakter angka tanpa tanda hubung.</p>
                                @error('isbn')
                                    <div class="text-[12px] font-medium text-danger mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">error</span>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Kategori Relasional -->
                            <div>
                                <label for="kategori_id" class="block text-[12px] font-bold text-[#231D2D] uppercase tracking-wider mb-2 font-mono">
                                    Kategori Rumpun Ilmu <span class="text-danger">*</span>
                                </label>
                                <select name="kategori_id" 
                                        id="kategori_id" 
                                        class="w-full form-select-classy @error('kategori_id') border-red-500 bg-red-50/30 @enderror"
                                        required>
                                    <option value="">-- Pilih Bidang Ilmu / Kategori --</option>
                                    @foreach($kategoris ?? [] as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $buku->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }} ({{ $kategori->kode_kategori }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[11px] text-[#78716C] mt-1.5">Relasi foreign key ke tabel `kategoris`.</p>
                                @error('kategori_id')
                                    <div class="text-[12px] font-medium text-danger mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">error</span>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Judul Buku (Full Width) -->
                            <div class="md:col-span-2">
                                <label for="judul" class="block text-[12px] font-bold text-[#231D2D] uppercase tracking-wider mb-2 font-mono">
                                    Judul Lengkap Buku <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="judul" 
                                       id="judul" 
                                       value="{{ old('judul', $buku->judul ?? '') }}"
                                       placeholder="Contoh: Struktur Data & Algoritma Lanjut dengan Python" 
                                       class="w-full form-control-classy @error('judul') border-red-500 bg-red-50/30 @enderror"
                                       required>
                                <p class="text-[11px] text-[#78716C] mt-1.5">Minimal 5 karakter, maksimal 255 karakter.</p>
                                @error('judul')
                                    <div class="text-[12px] font-medium text-danger mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">error</span>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Penulis -->
                            <div>
                                <label for="penulis" class="block text-[12px] font-bold text-[#231D2D] uppercase tracking-wider mb-2 font-mono">
                                    Nama Penulis / Pengarang <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="penulis" 
                                       id="penulis" 
                                       value="{{ old('penulis', $buku->penulis ?? '') }}"
                                       placeholder="Contoh: Rinaldi Munir, M.T." 
                                       class="w-full form-control-classy @error('penulis') border-red-500 bg-red-50/30 @enderror"
                                       required>
                                @error('penulis')
                                    <div class="text-[12px] font-medium text-danger mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">error</span>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Penerbit -->
                            <div>
                                <label for="penerbit" class="block text-[12px] font-bold text-[#231D2D] uppercase tracking-wider mb-2 font-mono">
                                    Nama Penerbit <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="penerbit" 
                                       id="penerbit" 
                                       value="{{ old('penerbit', $buku->penerbit ?? '') }}"
                                       placeholder="Contoh: IT Del Press / Penerbit Informatika" 
                                       class="w-full form-control-classy @error('penerbit') border-red-500 bg-red-50/30 @enderror"
                                       required>
                                @error('penerbit')
                                    <div class="text-[12px] font-medium text-danger mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">error</span>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Tahun Terbit -->
                            <div>
                                <label for="tahun_terbit" class="block text-[12px] font-bold text-[#231D2D] uppercase tracking-wider mb-2 font-mono">
                                    Tahun Publikasi <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       name="tahun_terbit" 
                                       id="tahun_terbit" 
                                       value="{{ old('tahun_terbit', $buku->tahun_terbit ?? date('Y')) }}"
                                       min="1900" 
                                       max="{{ date('Y') + 1 }}"
                                       class="w-full form-control-classy font-mono @error('tahun_terbit') border-red-500 bg-red-50/30 @enderror"
                                       required>
                                <p class="text-[11px] text-[#78716C] mt-1.5 font-mono">Rentang valid: 1900 &ndash; {{ date('Y') + 1 }}.</p>
                                @error('tahun_terbit')
                                    <div class="text-[12px] font-medium text-danger mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">error</span>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Stok Fisik -->
                            <div>
                                <label for="stok" class="block text-[12px] font-bold text-[#231D2D] uppercase tracking-wider mb-2 font-mono">
                                    Jumlah Stok Eksemplar Fisik <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       name="stok" 
                                       id="stok" 
                                       value="{{ old('stok', $buku->stok ?? 0) }}"
                                       min="0"
                                       class="w-full form-control-classy font-mono @error('stok') border-red-500 bg-red-50/30 @enderror"
                                       required>
                                <p class="text-[11px] text-[#78716C] mt-1.5">Jumlah buku fisik di rak (minimal 0).</p>
                                @error('stok')
                                    <div class="text-[12px] font-medium text-danger mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">error</span>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Sinopsis (Full Width) -->
                            <div class="md:col-span-2">
                                <label for="sinopsis" class="block text-[12px] font-bold text-[#231D2D] uppercase tracking-wider mb-2 font-mono">
                                    Sinopsis & Deskripsi Konten Buku (Opsional)
                                </label>
                                <textarea name="sinopsis" 
                                          id="sinopsis" 
                                          rows="4"
                                          placeholder="Tuliskan ringkasan pokok materi, bab utama, atau target pembaca monograf ini..." 
                                          class="w-full form-control-classy @error('sinopsis') border-red-500 bg-red-50/30 @enderror">{{ old('sinopsis', $buku->sinopsis ?? '') }}</textarea>
                                @error('sinopsis')
                                    <div class="text-[12px] font-medium text-danger mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">error</span>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                        </div>

                        <!-- Form Action Buttons -->
                        <div class="pt-6 border-t border-[#E8E1D5] mt-6 flex items-center justify-end gap-3">
                            <a href="{{ url('/buku') }}" class="btn btn-del-outline text-xs px-4 py-2.5 rounded-lg no-underline">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-del text-xs px-5 py-2.5 rounded-lg inline-flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px] text-[#F2C58F]">check</span>
                                <span>Perbarui Koleksi Buku</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Live Monograph Card Preview (Col 4 - Sticky) -->
            <div class="lg:col-span-4 sticky top-28" id="book-live-preview">
                <div class="card-classy p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between pb-3 border-b border-[#F0EBE1]">
                        <span class="text-[11px] font-bold text-[#766E62] uppercase tracking-wider font-mono flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                            Live Catalog Preview
                        </span>
                        <span class="text-[10px] font-mono text-[#9CA3AF]">Realtime</span>
                    </div>

                    <!-- Tome Book 3D Preview -->
                    <div class="tome-book-cover aspect-[1/1.35] p-5 flex flex-col justify-between relative overflow-hidden">
                        <div class="tome-spine-line"></div>
                        <div class="flex items-center justify-between text-[9px] font-mono pl-3">
                            <span class="text-[#E6C387] font-semibold uppercase" id="preview-penerbit">{{ $buku->penerbit ?? 'Penerbit IT Del' }}</span>
                            <span class="material-symbols-outlined text-[15px] text-[#E6C387]">school</span>
                        </div>

                        <div class="pl-3 my-auto text-center space-y-1.5">
                            <span class="font-mono text-[8px] uppercase tracking-widest text-white/50 block">Monograf Perpustakaan</span>
                            <h3 class="text-[15px] font-bold text-[#F8E7C8] tracking-tight leading-snug line-clamp-3" id="preview-judul">
                                {{ $buku->judul ?? 'Judul Monograf Buku' }}
                            </h3>
                            <div class="h-0.5 w-8 bg-[#E6C387] mx-auto rounded-full"></div>
                            <span class="text-[11px] text-white/80 font-medium block truncate" id="preview-penulis">
                                {{ $buku->penulis ?? 'Nama Penulis' }}
                            </span>
                        </div>

                        <div class="pt-2 border-t border-white/10 flex items-center justify-between text-[10px] font-mono text-white/40 pl-3">
                            <span id="preview-isbn">{{ $buku->isbn ?? '978-0000000000' }}</span>
                            <span id="preview-tahun">{{ $buku->tahun_terbit ?? date('Y') }}</span>
                        </div>
                    </div>

                    <!-- Metadata summary -->
                    <div class="p-3 rounded-lg bg-[#FAF7F2] border border-[#E8DFD1] text-xs space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-[#78716C]">Kategori:</span>
                            <span class="font-semibold text-[#312052]" id="preview-kategori">
                                {{ $buku->kategori ? $buku->kategori->nama_kategori : 'Belum Dipilih' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[#78716C]">Alokasi Stok:</span>
                            <span class="font-semibold {{ ($buku->stok ?? 0) > 0 ? 'text-emerald-700' : 'text-red-600' }}" id="preview-stok">
                                {{ $buku->stok ?? 0 }} Eks.
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-layout>
