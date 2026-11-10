<x-layout title="{{ $buku->judul ?? 'Detail Buku' }}">
    <div class="flex flex-col gap-6">

        <!-- Breadcrumb & Top Command Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <nav class="flex items-center flex-wrap gap-2 text-[13px] text-[#78716C]">
                <a class="hover:text-[#312052] transition-colors flex items-center gap-1 font-medium text-[#78716C] no-underline" href="{{ url('/buku') }}">
                    <span class="material-symbols-outlined text-[17px] text-[#B4681E]">roofing</span>
                    <span>Katalog</span>
                </a>
                <span class="font-mono text-[11px] text-[#CBC4CF]">/</span>
                <span class="text-[#312052] font-semibold flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px] text-[#B4681E]">menu_book</span>
                    <span>Detail: {{ Str::limit($buku->judul ?? 'Informasi Buku', 40) }}</span>
                </span>
            </nav>

            <div class="flex items-center gap-2.5 flex-wrap">
                <a href="{{ url('/buku') }}" class="btn btn-del-outline text-xs px-3.5 py-2 rounded-lg inline-flex items-center gap-1.5 no-underline">
                    <span class="material-symbols-outlined text-[17px]">arrow_back</span>
                    <span>Kembali ke Katalog</span>
                </a>

                <a href="{{ url('/buku/' . ($buku->id ?? '') . '/edit') }}" class="btn btn-del text-xs px-3.5 py-2 rounded-lg inline-flex items-center gap-1.5 no-underline shadow-sm">
                    <span class="material-symbols-outlined text-[17px]">edit</span>
                    <span>Edit Data Buku</span>
                </a>

                <form action="{{ url('/buku/' . ($buku->id ?? '')) }}" method="POST" class="inline" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini dari katalog perpustakaan?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger text-xs px-3.5 py-2 rounded-lg inline-flex items-center gap-1.5 border border-red-200 text-red-600 hover:bg-red-50">
                        <span class="material-symbols-outlined text-[17px]">delete</span>
                        <span>Hapus</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Two-Column Academic Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Column: Visual Tome Presentation & Physical Status -->
            <div class="lg:col-span-4 flex flex-col gap-5 stagger-item">
                
                <!-- Book Cover Visual Card (Tome 3D Style) -->
                <div class="card-classy p-6 flex flex-col items-center relative overflow-hidden group">
                    <div class="absolute -top-16 -right-16 w-36 h-36 rounded-full bg-[#F5DEBF]/40 blur-2xl pointer-events-none"></div>
                    <div class="absolute -bottom-16 -left-16 w-36 h-36 rounded-full bg-[#E5D7EB]/30 blur-2xl pointer-events-none"></div>

                    <!-- Academic Tome Cover -->
                    <div class="tome-book-cover w-full max-w-[230px] aspect-[1/1.42] p-5 flex flex-col justify-between relative overflow-hidden">
                        <!-- Book Spine Accent Texture -->
                        <div class="tome-spine-line"></div>

                        <!-- Foil Header Stamp -->
                        <div class="flex items-center justify-between relative z-10 pl-2">
                            <span class="font-mono text-[9px] uppercase tracking-widest text-[#E6C387]">IT Del Press</span>
                            <span class="material-symbols-outlined text-[16px] text-[#E6C387]">school</span>
                        </div>

                        <!-- Central Foil Typography -->
                        <div class="my-auto text-center relative z-10 flex flex-col gap-2 pl-2">
                            <span class="font-mono text-[9px] uppercase tracking-widest text-white/50">Monograf Akademik</span>
                            <h3 class="text-[15px] font-bold text-[#F8E7C8] tracking-tight leading-snug">
                                {{ $buku->judul ?? 'Judul Buku' }}
                            </h3>
                            <div class="h-0.5 w-10 bg-[#E6C387] mx-auto rounded-full my-1"></div>
                            <span class="text-[11px] text-white/80 font-medium truncate">
                                {{ $buku->penulis ?? 'Penulis' }}
                            </span>
                        </div>

                        <!-- Bottom Seal -->
                        <div class="pt-2 border-t border-white/10 flex items-center justify-between text-[10px] font-mono text-white/40 relative z-10 pl-2">
                            <span>ISBN 13</span>
                            <span>{{ $buku->tahun_terbit ?? '2026' }}</span>
                        </div>
                    </div>

                    <!-- Shelf Location Card -->
                    <div class="w-full mt-5 pt-4 border-t border-[#E8E1D5] flex items-center justify-between text-xs font-mono text-[#78716C]">
                        <span>LOKASI RAK FISIK:</span>
                        <span class="font-bold text-[#312052] bg-[#FAF7F2] px-2.5 py-1 rounded border border-[#E8E1D5]">
                            RAK-{{ $buku->kategori->kode_kategori ?? 'DEL' }}
                        </span>
                    </div>
                </div>

                <!-- Stock & Availability Card with Visual Meter -->
                <div class="card-classy p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[11px] font-bold text-[#766E62] uppercase tracking-wider font-mono">Status Ketersediaan</span>
                        @if(($buku->stok ?? 0) > 0)
                            <span class="badge-stok-tersedia">Tersedia</span>
                        @else
                            <span class="badge-stok-habis">Stok Habis</span>
                        @endif
                    </div>
                    
                    <div class="flex items-baseline gap-2 mb-2">
                        <span class="text-[32px] font-bold text-[#231D2D]">{{ $buku->stok ?? 0 }}</span>
                        <span class="text-[13px] text-[#7C7467]">Eksemplar Fisik di Rak</span>
                    </div>

                    <!-- Stock Progress Meter -->
                    @php
                        $stokVal = $buku->stok ?? 0;
                        $persen = min(100, max(0, ($stokVal / 15) * 100));
                        $meterColor = $stokVal > 3 ? '#2D5F43' : ($stokVal > 0 ? '#B4681E' : '#991B1B');
                    @endphp
                    <div class="w-full bg-[#EAE3D6] h-2 rounded-full overflow-hidden mb-3">
                        <div class="h-full rounded-full transition-all duration-500" style="width: {{ $persen }}%; background-color: {{ $meterColor }};"></div>
                    </div>

                    <p class="text-[12px] text-[#78716C] mb-0 leading-relaxed">
                        @if(($buku->stok ?? 0) > 0)
                            Buku ini siap dipinjam oleh civitas akademika IT Del melalui meja sirkulasi perpustakaan.
                        @else
                            Seluruh eksemplar saat ini sedang dalam peminjaman aktif. Silakan hubungi pustakawan untuk reservasi antrian.
                        @endif
                    </p>
                </div>

            </div>

            <!-- Right Column: Bibliographic Details & Synopsis -->
            <div class="lg:col-span-8 flex flex-col gap-5 stagger-item">
                
                <!-- Main Monograph Header Card -->
                <div class="card-classy p-6 sm:p-8">
                    
                    <div class="flex items-center gap-2 mb-3">
                        <span class="badge-kategori-classy">
                            {{ $buku->kategori->nama_kategori ?? 'Kategori Umum' }}
                        </span>
                        <span class="text-[12px] font-mono text-[#78716C]">&bull;</span>
                        <span class="text-[12px] font-mono text-[#78716C]">Kode: {{ $buku->kategori->kode_kategori ?? 'DEL' }}</span>
                    </div>

                    <h1 class="text-[24px] sm:text-[28px] font-bold text-[#1E1A28] tracking-tight leading-snug mb-2">
                        {{ $buku->judul ?? 'Judul Buku' }}
                    </h1>

                    <div class="flex items-center gap-2 text-[14px] text-[#78716C] pb-5 border-b border-[#E8E1D5] mb-6 flex-wrap">
                        <span>Penulis: <strong class="text-[#231D2D]">{{ $buku->penulis ?? 'Tidak Diketahui' }}</strong></span>
                        <span>&bull;</span>
                        <span>Penerbit: <strong class="text-[#231D2D]">{{ $buku->penerbit ?? 'Penerbit Del' }}</strong></span>
                        <span>&bull;</span>
                        <span class="font-mono">Tahun: <strong class="text-[#231D2D]">{{ $buku->tahun_terbit ?? '-' }}</strong></span>
                    </div>

                    <!-- Bibliographic Metadata Grid -->
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-[13px] font-bold text-[#1E1A28] uppercase tracking-wider font-mono mb-0">
                            Spesifikasi Bibliografi
                        </h4>
                        <!-- Copy ISBN Quick Button with Anime.js feedback -->
                        <button type="button" class="btn-copy-isbn inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-mono font-medium text-[#78716C] bg-[#FAF7F2] border border-[#E8E1D5] hover:bg-[#F3EFE9] transition-all" data-isbn="{{ $buku->isbn }}">
                            <span class="material-symbols-outlined text-[15px] copy-icon">content_copy</span>
                            <span class="copy-text">Salin ISBN</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                        <div class="p-3.5 rounded-xl bg-[#FAF7F2] border border-[#E8E1D5]">
                            <div class="text-[11px] font-mono text-[#78716C] uppercase">Nomor Standar ISBN</div>
                            <div class="text-[15px] font-bold font-mono text-[#312052] mt-0.5">{{ $buku->isbn ?? '-' }}</div>
                        </div>

                        <div class="p-3.5 rounded-xl bg-[#FAF7F2] border border-[#E8E1D5]">
                            <div class="text-[11px] font-mono text-[#78716C] uppercase">Kategori & Klasifikasi</div>
                            <div class="text-[14px] font-bold text-[#312052] mt-0.5">{{ $buku->kategori->nama_kategori ?? '-' }}</div>
                        </div>

                        <div class="p-3.5 rounded-xl bg-[#FAF7F2] border border-[#E8E1D5]">
                            <div class="text-[11px] font-mono text-[#78716C] uppercase">Instansi Penerbit</div>
                            <div class="text-[14px] font-semibold text-[#231D2D] mt-0.5">{{ $buku->penerbit ?? '-' }}</div>
                        </div>

                        <div class="p-3.5 rounded-xl bg-[#FAF7F2] border border-[#E8E1D5]">
                            <div class="text-[11px] font-mono text-[#78716C] uppercase">Tahun Publikasi</div>
                            <div class="text-[14px] font-semibold text-[#231D2D] mt-0.5">{{ $buku->tahun_terbit ?? '-' }}</div>
                        </div>
                    </div>

                    <!-- Narrative Synopsis -->
                    <h4 class="text-[13px] font-bold text-[#1E1A28] uppercase tracking-wider font-mono mb-2">
                        Sinopsis & Ringkasan Konten
                    </h4>
                    
                    <div class="p-4 rounded-xl bg-[#FAF8F5] border border-[#E8E1D5] text-[14px] text-[#49454E] leading-relaxed">
                        @if($buku->sinopsis)
                            <p class="mb-0 whitespace-pre-line">{{ $buku->sinopsis }}</p>
                        @else
                            <p class="mb-0 text-muted italic">Belum ada sinopsis naratif yang ditambahkan untuk monograf ini.</p>
                        @endif
                    </div>

                </div>

            </div>

        </div>

    </div>
</x-layout>
