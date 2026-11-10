<x-layout title="Manajemen Kategori">
    <div class="flex flex-col gap-6">

        <!-- Breadcrumb & Top Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-[13px] text-[#78716C]">
            <nav class="flex items-center gap-2">
                <a class="hover:text-[#312052] transition-colors flex items-center gap-1.5 font-medium text-[#78716C] no-underline" href="{{ url('/buku') }}">
                    <span class="material-symbols-outlined text-[17px] text-[#B4681E]">roofing</span>
                    <span>Katalog</span>
                </a>
                <span class="text-[#CBC4CF] font-mono text-[11px]">/</span>
                <span class="text-[#312052] font-semibold px-2.5 py-0.5 rounded-full bg-[#EAE1DA]">
                    Manajemen Kategori
                </span>
            </nav>
            <div class="flex items-center gap-2 text-[12px] text-[#78716C]">
                <span class="w-2 h-2 rounded-full bg-[#B4681E]"></span>
                <span>Taksonomi Rumpun Ilmu Perpustakaan Del</span>
            </div>
        </div>

        <!-- Page Header Card -->
        <div class="relative overflow-hidden rounded-2xl bg-[#F6ECE6] border border-[#E8E1D5] p-6 sm:p-8 shadow-sm">
            <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="max-w-2xl space-y-2">
                    <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-[#312052] text-white text-[11px] font-semibold tracking-wider uppercase font-mono">
                        <span class="material-symbols-outlined text-[15px] text-[#F2C58F]">account_tree</span>
                        <span>Master Entitas Klasifikasi</span>
                    </div>
                    <h1 class="text-[26px] sm:text-[30px] font-bold text-[#1E1A28] tracking-tight leading-tight">
                        Struktur & Manajemen Kategori Buku
                    </h1>
                    <p class="text-[14px] text-[#5C5449] leading-relaxed">
                        Kelola data rumpun bidang ilmu perpustakaan IT Del untuk mengorganisasi koleksi monograf, buku ajar, dan referensi akademik secara terstruktur.
                    </p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ url('/kategori/create') }}" class="btn btn-del px-4 py-2.5 rounded-lg flex items-center gap-2 text-[13px] no-underline shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                        <span>+ Tambah Kategori Baru</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Category Table Card -->
        <div class="card-classy overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-[#E8E1D5] bg-[#FAF7F2] flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#B4681E] text-[20px]">folder_open</span>
                    <h3 class="text-[16px] font-bold text-[#231D2D] mb-0 tracking-tight">Daftar Kategori Terdaftar</h3>
                </div>
                <div class="text-[12px] font-mono text-[#78716C]">
                    Total: <strong class="text-[#312052]">{{ count($kategoris ?? []) }} Kategori</strong>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F6F2EB] border-b border-[#E8E1D5] text-[#696155] text-[11px] font-semibold uppercase tracking-wider font-mono">
                            <th class="py-3.5 px-4 text-center w-14">No</th>
                            <th class="py-3.5 px-4 w-40">Kode Kategori</th>
                            <th class="py-3.5 px-4">Nama Bidang Ilmu / Kategori</th>
                            <th class="py-3.5 px-4 text-center w-44">Jumlah Buku Terkait</th>
                            <th class="py-3.5 px-4 text-right w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F2ECE2] text-[13px] text-[#292420]">
                        @forelse($kategoris as $index => $kategori)
                        <tr class="hover:bg-[#FAF7F2] transition-colors group stagger-item">
                            <td class="py-4 px-4 text-center font-mono text-[12px] text-[#8F8678]">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="font-mono text-[12px] font-bold px-2.5 py-1 rounded bg-[#F4EFE6] text-[#312052] border border-[#E5DDCF]">
                                    {{ $kategori->kode_kategori }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-semibold text-[14px] text-[#201B29] group-hover:text-[#483660] transition-colors">
                                    {{ $kategori->nama_kategori }}
                                </div>
                                <div class="text-[11px] text-[#8F8678] font-mono mt-0.5">
                                    Ditambahkan: {{ $kategori->created_at ? $kategori->created_at->format('d M Y') : 'Sistem Del' }}
                                </div>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="badge-kategori-classy inline-flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[13px]">book</span>
                                    <span>{{ $kategori->bukus_count ?? ($kategori->bukus ? $kategori->bukus->count() : 0) }} Judul Buku</span>
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ url('/kategori/' . $kategori->id . '/edit') }}" 
                                       class="p-1.5 rounded-lg text-[#786E60] hover:text-[#B4681E] hover:bg-[#FAF4EC] transition-all no-underline" 
                                       title="Edit Kategori">
                                        <span class="material-symbols-outlined text-[19px]">edit</span>
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ url('/kategori/' . $kategori->id) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $kategori->nama_kategori }}? Seluruh buku dalam kategori ini akan ikut terhapus (Cascade Delete)!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-1.5 rounded-lg text-[#786E60] hover:text-[#991B1B] hover:bg-[#FDF2F2] transition-all border-0 bg-transparent" 
                                                title="Hapus Kategori">
                                            <span class="material-symbols-outlined text-[19px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8">
                                <x-empty-state 
                                    title="Belum Ada Kategori Terdaftar" 
                                    message="Master kategori buku perpustakaan masih kosong. Silakan tambahkan kategori perdana untuk mengelompokkan koleksi buku."
                                    :actionUrl="url('/kategori/create')"
                                    actionLabel="Tambah Kategori Perdana"
                                    icon="category"
                                />
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layout>
