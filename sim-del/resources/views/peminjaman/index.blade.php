<x-layout title="Sirkulasi Peminjaman">
    <div class="space-y-6">

        <!-- Top Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-[#E8E1D5]">
            <div>
                <nav class="flex items-center gap-2 text-xs text-[#7A7265] mb-1 font-medium">
                    <a href="{{ route('buku.index') }}" class="hover:text-[#1E1A28] no-underline">Beranda</a>
                    <span class="text-xs">&bull;</span>
                    <span class="text-[#2B213A] font-semibold">Sirkulasi Perpustakaan</span>
                </nav>
                <h1 class="text-2xl font-bold tracking-tight text-[#1E1A28] flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[28px] text-[#312052]">sync_alt</span>
                    <span>Sirkulasi Transaksi Peminjaman & Pengembalian</span>
                </h1>
                <p class="text-xs text-[#7A7265] mt-1">
                    Pencatatan sirkulasi buku berbasis transaksi ACID (<code class="font-mono text-[#312052] bg-[#FAF0E4] px-1 py-0.5 rounded">DB::transaction</code>) dan Pessimistic Locking (<code class="font-mono text-[#312052] bg-[#FAF0E4] px-1 py-0.5 rounded">lockForUpdate</code>).
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <a href="{{ route('peminjaman.create') }}" class="btn-del inline-flex items-center gap-2 text-xs px-4 py-2.5 rounded-lg no-underline shadow-sm hover:shadow">
                    <span class="material-symbols-outlined text-[17px]">add_task</span>
                    <span>Transaksi Pinjam Baru</span>
                </a>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="card-classy p-4">
            <form method="GET" action="{{ route('peminjaman.index') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                
                <!-- Status Filter Pills -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0">
                    <a href="{{ route('peminjaman.index', array_merge(request()->except('status', 'page'), [])) }}" 
                       class="px-3 py-1.5 rounded-full text-xs font-semibold no-underline transition-all {{ !request()->filled('status') ? 'bg-[#312052] text-white shadow-sm' : 'bg-[#FAF7F2] text-[#554D40] hover:bg-[#EFE8DD]' }}">
                        Semua Status
                    </a>
                    <a href="{{ route('peminjaman.index', array_merge(request()->except('page'), ['status' => 'dipinjam'])) }}" 
                       class="px-3 py-1.5 rounded-full text-xs font-semibold no-underline transition-all {{ request('status') === 'dipinjam' ? 'bg-[#B4681E] text-white shadow-sm' : 'bg-[#FAF7F2] text-[#554D40] hover:bg-[#EFE8DD]' }}">
                        Sedang Dipinjam
                    </a>
                    <a href="{{ route('peminjaman.index', array_merge(request()->except('page'), ['status' => 'dikembalikan'])) }}" 
                       class="px-3 py-1.5 rounded-full text-xs font-semibold no-underline transition-all {{ request('status') === 'dikembalikan' ? 'bg-[#2D5F43] text-white shadow-sm' : 'bg-[#FAF7F2] text-[#554D40] hover:bg-[#EFE8DD]' }}">
                        Selesai Dikembalikan
                    </a>
                </div>

                <!-- Search Input -->
                <div class="flex items-center gap-2 w-full md:w-auto">
                    @if(request()->filled('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="relative w-full md:w-80">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-[18px] text-[#A89E8D]">search</span>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari NIM, Mahasiswa, Kode, Judul..." 
                               class="form-control-classy pl-9 pr-3 py-2 text-xs w-full">
                    </div>
                    <button type="submit" class="btn-del px-3 py-2 text-xs rounded-lg">
                        Cari
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('peminjaman.index') }}" class="btn-del-outline px-2.5 py-2 text-xs rounded-lg no-underline text-center" title="Reset Filter">
                            <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Table Listing -->
        <div class="card-classy overflow-hidden">
            @if($peminjamans->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-[#FAF0E4] border border-[#F3E1C8] flex items-center justify-center text-[#9A5B18]">
                        <span class="material-symbols-outlined text-[32px]">folder_off</span>
                    </div>
                    <h3 class="text-base font-bold text-[#1E1A28]">Belum Ada Transaksi Peminjaman</h3>
                    <p class="text-xs text-[#7A7265] max-w-md mx-auto mt-1 mb-4">
                        Tidak ada riwayat peminjaman yang cocok dengan kriteria pencarian atau belum ada transaksi yang tercatat.
                    </p>
                    <a href="{{ route('peminjaman.create') }}" class="btn-del inline-flex items-center gap-2 text-xs px-4 py-2 rounded-lg no-underline">
                        <span class="material-symbols-outlined text-[16px]">add</span>
                        <span>Mulai Transaksi Pinjam Baru</span>
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead class="bg-[#FAF7F2] border-b border-[#E8E1D5] text-[#554D40] uppercase tracking-wider font-semibold text-[10px]">
                            <tr>
                                <th class="py-3 px-2.5 whitespace-nowrap">Kode</th>
                                <th class="py-3 px-2.5 whitespace-nowrap">Buku & Kategori</th>
                                <th class="py-3 px-2.5 whitespace-nowrap">Peminjam</th>
                                <th class="py-3 px-2 whitespace-nowrap">Tgl Pinjam</th>
                                <th class="py-3 px-2 whitespace-nowrap">Jatuh Tempo</th>
                                <th class="py-3 px-2 whitespace-nowrap">Tgl Kembali</th>
                                <th class="py-3 px-2 text-center whitespace-nowrap">Status</th>
                                <th class="py-3 px-2.5 text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E8E1D5]">
                            @foreach($peminjamans as $pinjam)
                                <tr class="hover:bg-[#FCFBF8] transition-colors">
                                    
                                    <!-- Kode Pinjam -->
                                    <td class="py-3 px-2.5 font-mono font-bold text-[#312052] whitespace-nowrap text-[11px]">
                                        {{ $pinjam->kode_pinjam }}
                                    </td>

                                    <!-- Buku & Kategori -->
                                    <td class="py-3 px-2.5">
                                        <div class="font-bold text-[#1E1A28] max-w-[170px] xl:max-w-[220px] truncate" title="{{ $pinjam->buku->judul ?? '-' }}">
                                            {{ $pinjam->buku->judul ?? 'Buku Telah Dihapus' }}
                                        </div>
                                        <div class="flex flex-col gap-0.5 mt-0.5">
                                            <span class="font-mono text-[10px] text-[#7A7265] whitespace-nowrap">ISBN: {{ $pinjam->buku->isbn ?? '-' }}</span>
                                            @if($pinjam->buku && $pinjam->buku->kategori)
                                                <div>
                                                    <span class="inline-block text-[9px] px-1.5 py-0.5 rounded bg-[#FAF0E4] text-[#9A5B18] font-medium border border-[#F3E1C8] whitespace-nowrap">
                                                        {{ $pinjam->buku->kategori->nama_kategori }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Peminjam -->
                                    <td class="py-3 px-2.5 whitespace-nowrap">
                                        <div class="font-semibold text-[#1E1A28] text-xs">{{ $pinjam->nama_peminjam }}</div>
                                        <div class="font-mono text-[10px] text-[#7A7265] mt-0.5">NIM: {{ $pinjam->nim_peminjam }}</div>
                                    </td>

                                    <!-- Tgl Pinjam -->
                                    <td class="py-3 px-2 text-[#554D40] whitespace-nowrap text-xs">
                                        {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->translatedFormat('d M Y') }}
                                    </td>

                                    <!-- Jatuh Tempo -->
                                    <td class="py-3 px-2 whitespace-nowrap text-xs">
                                        <div>{{ \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->translatedFormat('d M Y') }}</div>
                                        @if($pinjam->status === 'dipinjam')
                                            @php
                                                $today = \Carbon\Carbon::today();
                                                $tempo = \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo);
                                                $diff = $today->diffInDays($tempo, false);
                                            @endphp
                                            @if($diff < 0)
                                                <span class="inline-flex items-center gap-1 text-[9px] font-bold text-red-600 bg-red-50 border border-red-200 px-1 py-0.5 rounded mt-0.5">
                                                    <i class="bi bi-exclamation-triangle-fill"></i> Terlambat {{ abs($diff) }}h
                                                </span>
                                            @elseif($diff == 0)
                                                <span class="inline-flex items-center gap-1 text-[9px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-1 py-0.5 rounded mt-0.5">
                                                    <i class="bi bi-clock-fill"></i> Batas akhir
                                                </span>
                                            @else
                                                <span class="text-[9px] text-[#7A7265] mt-0.5 block">
                                                    Sisa {{ $diff }} hari
                                                </span>
                                            @endif
                                        @endif
                                    </td>

                                    <!-- Tgl Kembali -->
                                    <td class="py-3 px-2 text-[#554D40] whitespace-nowrap text-xs">
                                        @if($pinjam->tanggal_kembali)
                                            <span class="text-[#2D5F43] font-medium flex items-center gap-1">
                                                <i class="bi bi-check-circle-fill text-[10px]"></i>
                                                {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->translatedFormat('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-[#A89E8D] italic font-mono">-</span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="py-3 px-2 text-center whitespace-nowrap">
                                        @if($pinjam->status === 'dipinjam')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#FDF8F0] text-[#9A5B18] border border-[#F3E1C8]">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#B4681E] animate-pulse"></span>
                                                Dipinjam
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#F2F7F4] text-[#2D5F43] border border-[#CCE3D6]">
                                                <i class="bi bi-check-lg text-[11px]"></i>
                                                Dikembalikan
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-3 px-2.5 text-center whitespace-nowrap">
                                        @if($pinjam->status === 'dipinjam')
                                            <form action="{{ route('peminjaman.kembali', $pinjam->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin memproses pengembalian buku ini? Stok buku akan dikembalikan secara atomik.')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-del inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold shadow-xs hover:bg-[#25183E]">
                                                    <span class="material-symbols-outlined text-[14px]">assignment_return</span>
                                                    <span>Kembalikan</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[11px] text-[#A89E8D] font-medium italic">Selesai</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($peminjamans->hasPages())
                    <div class="p-4 border-t border-[#E8E1D5] bg-[#FAF7F2]">
                        {{ $peminjamans->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>
</x-layout>

