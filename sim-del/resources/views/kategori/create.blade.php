<x-layout title="Tambah Kategori Baru">
    <div class="max-w-2xl mx-auto flex flex-col gap-6">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-[13px] text-[#78716C]">
            <a class="hover:text-[#312052] transition-colors flex items-center gap-1.5 font-medium text-[#78716C] no-underline" href="{{ url('/kategori') }}">
                <span class="material-symbols-outlined text-[17px] text-[#B4681E]">arrow_back</span>
                <span>Manajemen Kategori</span>
            </a>
            <span class="text-[#CBC4CF] font-mono text-[11px]">/</span>
            <span class="text-[#312052] font-semibold px-2.5 py-0.5 rounded-full bg-[#EAE1DA]">
                Tambah Kategori
            </span>
        </nav>

        <!-- Form Card -->
        <div class="card-classy p-6 sm:p-8">
            <div class="flex items-center gap-3.5 pb-5 border-b border-[#E8E1D5] mb-6">
                <div class="w-12 h-12 rounded-xl bg-[#FAF6F0] border border-[#EADBCA] flex items-center justify-center text-[#B4681E] shadow-sm">
                    <span class="material-symbols-outlined text-[26px]">create_new_folder</span>
                </div>
                <div>
                    <h2 class="text-[20px] font-bold text-[#1E1A28] tracking-tight mb-0.5">Tambah Kategori Buku Baru</h2>
                    <p class="text-[13px] text-[#78716C] mb-0">Daftarkan kode dan nama rumpun keilmuan perpustakaan Del.</p>
                </div>
            </div>

            <form action="{{ url('/kategori') }}" method="POST">
                @csrf

                <!-- Kode Kategori -->
                <div class="mb-5">
                    <label for="kode_kategori" class="block text-[12px] font-bold text-[#231D2D] uppercase tracking-wider mb-2 font-mono">
                        Kode Kategori <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="kode_kategori" 
                           id="kode_kategori" 
                           value="{{ old('kode_kategori') }}"
                           placeholder="Contoh: INF, SI, TE, MAT" 
                           class="w-full form-control-classy font-mono @error('kode_kategori') border-red-500 bg-red-50/30 @enderror"
                           maxlength="20"
                           required>
                    <p class="text-[12px] text-[#78716C] mt-1.5">Kode klasifikasi unik (maksimal 20 karakter).</p>
                    @error('kode_kategori')
                        <div class="text-[12px] font-medium text-danger mt-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px]">error</span>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Nama Kategori -->
                <div class="mb-6">
                    <label for="nama_kategori" class="block text-[12px] font-bold text-[#231D2D] uppercase tracking-wider mb-2 font-mono">
                        Nama Kategori / Bidang Ilmu <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="nama_kategori" 
                           id="nama_kategori" 
                           value="{{ old('nama_kategori') }}"
                           placeholder="Contoh: Rekayasa Perangkat Lunak, Sains Terapan" 
                           class="w-full form-control-classy @error('nama_kategori') border-red-500 bg-red-50/30 @enderror"
                           maxlength="100"
                           required>
                    <p class="text-[12px] text-[#78716C] mt-1.5">Nama lengkap bidang studi atau rumpun koleksi buku (3-100 karakter).</p>
                    @error('nama_kategori')
                        <div class="text-[12px] font-medium text-danger mt-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px]">error</span>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="pt-5 border-t border-[#E8E1D5] flex items-center justify-end gap-3">
                    <a href="{{ url('/kategori') }}" class="btn btn-del-outline text-xs px-4 py-2.5 rounded-lg no-underline">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-del text-xs px-5 py-2.5 rounded-lg inline-flex items-center gap-2">
                        <span class="material-symbols-outlined text-[17px]">save</span>
                        <span>Simpan Kategori</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-layout>
