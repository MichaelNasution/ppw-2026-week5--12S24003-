<x-layout title="Tambah Buku Baru">
    <div class="flex flex-col gap-6">

        <!-- Breadcrumb & Top Bar -->
        <nav class="flex items-center gap-2 text-[13px] text-[#78716C]">
            <a class="hover:text-[#312052] transition-colors flex items-center gap-1.5 font-medium text-[#78716C] no-underline" href="{{ url('/buku') }}">
                <span class="material-symbols-outlined text-[17px] text-[#B4681E]">arrow_back</span>
                <span>Katalog Buku</span>
            </a>
            <span class="text-[#CBC4CF] font-mono text-[11px]">/</span>
            <span class="text-[#312052] font-semibold px-2.5 py-0.5 rounded-full bg-[#EAE1DA]">
                Tambah Buku Baru
            </span>
        </nav>

        <!-- Header Section -->
        <div class="relative overflow-hidden rounded-2xl bg-[#F6ECE6] border border-[#E8E1D5] p-6 sm:p-8 shadow-sm">
            <div class="relative z-10 max-w-2xl space-y-2">
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-[#312052] text-white text-[11px] font-semibold tracking-wider uppercase font-mono">
                    <span class="material-symbols-outlined text-[15px] text-[#F2C58F]">edit_note</span>
                    <span>Registrasi Bibliografi & Eksemplar</span>
                </div>
                <h1 class="text-[26px] sm:text-[30px] font-bold text-[#1E1A28] tracking-tight leading-tight">
                    Tambah Koleksi Monograf Buku
                </h1>
                <p class="text-[14px] text-[#5C5449] leading-relaxed">
                    Lengkapi metadata monograf akademik, kode ISBN 13 digit unik, dan jumlah stok fisik perpustakaan Institut Teknologi Del.
                </p>
            </div>
        </div>

        <!-- Validation Notice -->
        <div class="p-4 rounded-xl bg-[#FAF7F2] border border-[#E8E1D5] flex items-start gap-3">
            <span class="material-symbols-outlined text-[#B4681E] text-[22px] mt-0.5">policy</span>
            <div class="text-[13px] text-[#5C5449]">
                <strong class="text-[#1E1A28]">Ketentuan Server-Side Guard:</strong>
                ISBN wajib 13 digit unik, judul minimal 5 karakter, kategori wajib dipilih, dan stok berupa bilangan bulat non-negatif (&ge; 0).
            </div>
        </div>

        <!-- Form Card -->
        <div class="card-classy p-6 sm:p-8">
            <form action="{{ url('/buku') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="block text-[12px] font-bold text-[#231D2D] uppercase tracking-wider mb-2 font-mono">
                            Nomor ISBN (13 Digit) <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="isbn" 
                               id="isbn" 
                               value="{{ old('isbn') }}"
                               placeholder="Contoh: 9786020638294" 
                               maxlength="13"
                               class="w-full form-control-classy font-mono @error('isbn') border-red-500 bg-red-50/30 @enderror"
                               required>
                        <p class="text-[11px] text-[#78716C] mt-1.5 font-mono">Eksak 13 karakter angka tanpa spasi/tanda hubung.</p>
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
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
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
                               value="{{ old('judul') }}"
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
                               value="{{ old('penulis') }}"
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
                               value="{{ old('penerbit') }}"
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
                               value="{{ old('tahun_terbit', date('Y')) }}"
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
                               value="{{ old('stok', 1) }}"
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
                                  class="w-full form-control-classy @error('sinopsis') border-red-500 bg-red-50/30 @enderror">{{ old('sinopsis') }}</textarea>
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
                        <span class="material-symbols-outlined text-[18px] text-[#F2C58F]">save</span>
                        <span>Simpan ke Katalog</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-layout>
