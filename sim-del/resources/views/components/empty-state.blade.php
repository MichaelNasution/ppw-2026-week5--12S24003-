@props([
    'title' => 'Belum Ada Data Tersedia',
    'message' => 'Data belum tersedia di dalam sistem perpustakaan saat ini.',
    'actionUrl' => null,
    'actionLabel' => null,
    'icon' => 'menu_book'
])

<div class="py-12 px-4 text-center">
    <div class="w-16 h-16 mx-auto rounded-2xl bg-[#FAF6F0] border border-[#EADBCA] flex items-center justify-center text-[#B4681E] shadow-sm mb-3.5">
        <span class="material-symbols-outlined text-[32px]">{{ $icon }}</span>
    </div>
    <h4 class="text-[17px] font-bold text-[#231D2D] tracking-tight mb-1">{{ $title }}</h4>
    <p class="text-[13px] text-[#78716C] max-w-md mx-auto mb-4 leading-relaxed">{{ $message }}</p>
    
    @if($actionUrl && $actionLabel)
        <a href="{{ $actionUrl }}" class="btn btn-del btn-sm px-4 py-2 inline-flex items-center gap-2 rounded-lg text-xs">
            <span class="material-symbols-outlined text-[16px]">add</span>
            <span>{{ $actionLabel }}</span>
        </a>
    @endif
</div>
