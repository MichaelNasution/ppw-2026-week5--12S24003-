<x-layout title="Katalog Buku Perpustakaan">
    <div class="flex flex-col gap-6">

        <!-- Hero Header: Warm & Classy Del Academic Atmosphere -->
        <div class="relative overflow-hidden rounded-2xl bg-[#F4EFE6] border border-[#E8E1D5] p-6 sm:p-8 shadow-sm">
            <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-[#F5DEBF]/40 blur-3xl pointer-events-none"></div>
            <div class="absolute left-1/3 -bottom-24 w-72 h-72 rounded-full bg-[#E5D7EB]/35 blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                <div class="lg:col-span-8 space-y-3">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <span class="px-2.5 py-0.5 rounded-full bg-[#EBE1CF] text-[#865116] border border-[#DECFB5] font-mono text-[11px] font-semibold tracking-wider uppercase">
                            Dewey Classification OPAC
                        </span>
                        <span class="text-[#7A7268] text-[12px] font-medium flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#386641] inline-block animate-pulse"></span>
                            Del Central Archival System &bull; Sitoluama, Laguboti
                        </span>
                    </div>

                    <h1 class="text-[26px] sm:text-[32px] font-bold text-[#1E1A28] tracking-tight leading-snug">
                        Katalog Terpadu Perpustakaan Institut Teknologi Del
                    </h1>
                    
                    <p class="text-[14px] text-[#5C5449] max-w-2xl leading-relaxed">
                        Eksplorasi khazanah literatur komputasi, rekayasa perangkat lunak, sains murni, dan monograf ilmiah untuk mendukung tridharma civitas akademika IT Del.
                    </p>

                    <!-- Quick Search Bar -->
                    <form action="{{ url('/buku') }}" method="GET" class="mt-4 max-w-2xl">
                        <div class="relative flex items-center bg-white rounded-xl border border-[#DFD8CC] p-1.5 shadow-soft-card focus-within:border-[#483660] focus-within:ring-2 focus-within:ring-[#483660]/10 transition-all">
                            <span class="material-symbols-outlined text-[22px] text-[#A56722] ml-2.5">search</span>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari judul monograf, nama penulis, penerbit, atau nomor ISBN..." 
                                   class="w-full bg-transparent px-3 py-1.5 text-[14px] text-[#24201D] placeholder:text-[#9A9184] border-0 outline-none focus:ring-0">
                            
                            @if(request('kategori_id'))
                                <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
                            @endif

                            <button type="submit" class="btn btn-del px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-1.5 shrink-0">
                                <span>Cari</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Circulation Plate Card -->
                <div class="lg:col-span-4 flex justify-start lg:justify-end">
                    <div class="w-full max-w-sm rounded-2xl bg-white border border-[#E8E1D5] shadow-soft-card p-5 flex flex-col justify-between relative overflow-hidden">
                        <div class="flex items-center justify-between relative z-10">
                            <span class="font-mono text-[11px] font-semibold px-2.5 py-1 rounded bg-[#F4EFE6] text-[#2B213A] border border-[#E5DDCF]">
                                RAK DEL: UTAMA
                            </span>
                            <div class="flex items-center gap-1 text-[#386641] font-semibold text-[11px]">
                                <span class="w-2 h-2 rounded-full bg-[#386641] inline-block animate-pulse"></span>
                                <span>ONLINE</span>
                            </div>
                        </div>
                        <div class="my-4 text-center relative z-10">
                            <div class="w-12 h-12 mx-auto rounded-xl bg-[#FAF6F0] border border-[#EADBCA] flex items-center justify-center text-[#B4681E] shadow-sm mb-2">
                                <span class="material-symbols-outlined text-[26px]">auto_stories</span>
                            </div>
                            <h4 class="text-[16px] font-bold text-[#231D2D] tracking-tight">Sirkulasi Terpadu</h4>
                            <p class="text-[12px] text-[#6B6356] mb-0">Institut Teknologi Del &bull; Toba</p>
                        </div>
                        <div class="pt-3 border-t border-[#F2ECE2] flex items-center justify-between text-[#857B6C] text-[11px] font-mono">
                            <span>SINKRONISASI</span>
                            <span class="text-[#2B213A] font-semibold">100% TERHUBUNG</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Summary Metrics (4 Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1 -->
            <div class="card-classy p-4 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#766E62] uppercase tracking-wider font-mono">Total Koleksi</span>
                    <div class="w-8 h-8 rounded-lg bg-[#F5F1FA] border border-[#E6DDF2] flex items-center justify-center text-[#483660]">
                        <span class="material-symbols-outlined text-[18px]">library_books</span>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-[24px] font-bold text-[#1E1A28]">{{ $bukus->total() ?? count($bukus) }}</span>
                    <span class="text-[12px] text-[#7C7467] ml-1">Judul Terdata</span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="card-classy p-4 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#766E62] uppercase tracking-wider font-mono">Total Eksemplar</span>
                    <div class="w-8 h-8 rounded-lg bg-[#FAF4EC] border border-[#F0DFCC] flex items-center justify-center text-[#B4681E]">
                        <span class="material-symbols-outlined text-[18px]">shelves</span>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-[24px] font-bold text-[#8A4F13]">
                        {{ method_exists($bukus, 'sum') ? $bukus->sum('stok') : 'Aktif' }}
                    </span>
                    <span class="text-[12px] text-[#7C7467] ml-1">Fisik di Rak</span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="card-classy p-4 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#766E62] uppercase tracking-wider font-mono">Kategori</span>
                    <div class="w-8 h-8 rounded-lg bg-[#F0F5F2] border border-[#D5E5DC] flex items-center justify-center text-[#2D6A4F]">
                        <span class="material-symbols-outlined text-[18px]">category</span>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-[24px] font-bold text-[#2D6A4F]">{{ count($kategoris ?? []) }}</span>
                    <span class="text-[12px] text-[#7C7467] ml-1">Rumpun Ilmu</span>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="card-classy p-4 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#766E62] uppercase tracking-wider font-mono">Sirkulasi</span>
                    <div class="w-8 h-8 rounded-lg bg-[#FAF5EE] border border-[#E8DDCE] flex items-center justify-center text-[#6A573F]">
                        <span class="material-symbols-outlined text-[18px]">assignment_turned_in</span>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="text-[24px] font-bold text-[#2B213A]">Tersedia</span>
                    <span class="text-[12px] text-[#7C7467] ml-1">Siap Pinjam</span>
                </div>
            </div>
        </div>

        <!-- Filter & Action Bar -->
        <div class="card-classy p-4 flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">
            <!-- Filter by Kategori -->
            <form action="{{ url('/buku') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2.5 flex-1">
                <div class="relative w-full sm:w-64">
                    <select name="kategori_id" onchange="this.form.submit()" class="w-full form-select-classy text-[13px] pr-8 cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris ?? [] as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }} ({{ $kat->kode_kategori }})
                            </option>
                        @endforeach
                    </select>
                </div>

                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                @if(request('kategori_id') || request('search'))
                    <a href="{{ url('/buku') }}" class="btn btn-sm btn-del-outline text-xs px-3 py-2 rounded-lg flex items-center gap-1 no-underline">
                        <span class="material-symbols-outlined text-[15px]">clear</span>
                        <span>Reset Filter</span>
                    </a>
                @endif
            </form>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5 shrink-0">
                <a href="{{ url('/kategori') }}" class="btn btn-sm btn-del-outline text-xs px-3.5 py-2.5 rounded-lg flex items-center gap-1.5 no-underline">
                    <span class="material-symbols-outlined text-[17px]">category</span>
                    <span>Kelola Kategori</span>
                </a>

                <a href="{{ url('/buku/create') }}" class="btn btn-sm btn-del text-xs px-4 py-2.5 rounded-lg flex items-center gap-1.5 no-underline shadow-sm">
                    <span class="material-symbols-outlined text-[18px] text-[#F2C58F]">add</span>
                    <span>+ Tambah Buku Baru</span>
                </a>
            </div>
        </div>

        <!-- Book Catalog Modern Table Card -->
        <div class="card-classy overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F6F2EB] border-b border-[#E8E1D5] text-[#696155] text-[11px] font-semibold uppercase tracking-wider font-mono">
                            <th class="py-3.5 px-4 text-center w-12">No</th>
                            <th class="py-3.5 px-4 w-44">ISBN</th>
                            <th class="py-3.5 px-4">Informasi Buku & Bibliografi</th>
                            <th class="py-3.5 px-4 w-44">Kategori</th>
                            <th class="py-3.5 px-4 text-center w-36">Stok Fisik</th>
                            <th class="py-3.5 px-4 text-right w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F2ECE2] text-[13px] text-[#292420]">
                        @forelse($bukus as $index => $buku)
                        <tr class="hover:bg-[#FAF7F2] transition-colors group">
                            <td class="py-4 px-4 text-center font-mono text-[12px] text-[#8F8678]">
                                {{ method_exists($bukus, 'firstItem') ? ($bukus->firstItem() + $index) : ($index + 1) }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="font-mono text-[12px] font-medium text-[#2B213A] tracking-tight bg-[#F4EFE6] px-2 py-0.5 rounded border border-[#E5DDCF]">
                                    {{ $buku->isbn }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex flex-col">
                                    <a href="{{ url('/buku/' . $buku->id) }}" class="font-bold text-[14px] text-[#201B29] group-hover:text-[#483660] transition-colors tracking-tight no-underline">
                                        {{ $buku->judul }}
                                    </a>
                                    <div class="flex items-center gap-1.5 mt-1 text-[12px] text-[#6F6659] flex-wrap">
                                        <span class="font-medium text-[#3A332A]">{{ $buku->penulis }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $buku->penerbit }}</span>
                                        <span>&bull;</span>
                                        <span class="font-mono text-[11px]">Tahun {{ $buku->tahun_terbit }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="badge-kategori-classy inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">label</span>
                                    <span>{{ $buku->kategori->nama_kategori ?? 'Umum' }}</span>
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if($buku->stok > 0)
                                    <span class="badge-stok-tersedia inline-flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#2D6A4F]"></span>
                                        <span>{{ $buku->stok }} Eks.</span>
                                    </span>
                                @else
                                    <span class="badge-stok-habis inline-flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#991B1B]"></span>
                                        <span>Habis</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ url('/buku/' . $buku->id) }}" 
                                       class="p-1.5 rounded-lg text-[#786E60] hover:text-[#312052] hover:bg-[#F3EFE9] transition-all no-underline" 
                                       title="Lihat Detail Buku">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>

                                    <a href="{{ url('/buku/' . $buku->id . '/edit') }}" 
                                       class="p-1.5 rounded-lg text-[#786E60] hover:text-[#B4681E] hover:bg-[#FAF4EC] transition-all no-underline" 
                                       title="Ubah Data Buku">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ url('/buku/' . $buku->id) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku \'{{ addslashes($buku->judul) }}\'?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-1.5 rounded-lg text-[#786E60] hover:text-[#991B1B] hover:bg-[#FDF2F2] transition-all border-0 bg-transparent" 
                                                title="Hapus Buku">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8">
                                <x-empty-state 
                                    title="Koleksi Buku Tidak Ditemukan" 
                                    message="Tidak ada data buku yang sesuai dengan kriteria pencarian atau katalog masih kosong."
                                    :actionUrl="url('/buku/create')"
                                    actionLabel="Tambah Buku Perdana"
                                    icon="auto_stories"
                                />
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if(method_exists($bukus, 'hasPages') && $bukus->hasPages())
            <div class="p-4 border-t border-[#E8E1D5] bg-[#FAF7F2] flex items-center justify-between">
                <div class="text-[12px] text-[#78716C] font-mono">
                    Menampilkan <strong>{{ $bukus->firstItem() }}</strong> - <strong>{{ $bukus->lastItem() }}</strong> dari <strong>{{ $bukus->total() }}</strong> buku
                </div>
                <div>
                    {{ $bukus->links() }}
                </div>
            </div>
            @endif
        </div>

    </div>
</x-layout>
