@if(session('success'))
<div class="w-full bg-[#F2F7F4] border border-[#CCE3D6] border-l-4 border-l-[#2D5F43] rounded-xl p-4 shadow-subtle flex items-start justify-between gap-4 mb-6 transition-all" id="flash-alert-success">
    <div class="flex items-center gap-3.5">
        <div class="w-9 h-9 rounded-lg bg-[#2D5F43] text-white flex items-center justify-center shrink-0 shadow-sm">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
        </div>
        <div class="flex flex-col">
            <span class="text-[14px] font-bold text-[#1D4A36]">Aksi Berhasil!</span>
            <p class="text-[13px] text-[#34624C] mt-0.5 mb-0">
                {{ session('success') }}
            </p>
        </div>
    </div>
    <button class="text-[#52876E] hover:text-[#1D4A36] p-1 rounded-md transition-colors bg-transparent border-0" 
            onclick="document.getElementById('flash-alert-success').remove()" title="Tutup Notifikasi">
        <span class="material-symbols-outlined text-[20px]">close</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="w-full bg-[#FDF2F2] border border-[#FECACA] border-l-4 border-l-[#991B1B] rounded-xl p-4 shadow-subtle flex items-start justify-between gap-4 mb-6 transition-all" id="flash-alert-error">
    <div class="flex items-center gap-3.5">
        <div class="w-9 h-9 rounded-lg bg-[#991B1B] text-white flex items-center justify-center shrink-0 shadow-sm">
            <span class="material-symbols-outlined text-[20px]">error</span>
        </div>
        <div class="flex flex-col">
            <span class="text-[14px] font-bold text-[#7F1D1D]">Perhatian / Terjadi Kesalahan!</span>
            <p class="text-[13px] text-[#991B1B] mt-0.5 mb-0">
                {{ session('error') }}
            </p>
        </div>
    </div>
    <button class="text-[#B91C1C] hover:text-[#7F1D1D] p-1 rounded-md transition-colors bg-transparent border-0" 
            onclick="document.getElementById('flash-alert-error').remove()" title="Tutup Notifikasi">
        <span class="material-symbols-outlined text-[20px]">close</span>
    </button>
</div>
@endif
