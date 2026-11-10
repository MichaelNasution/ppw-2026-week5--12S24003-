<x-layout title="Masuk Pustakawan">
    <div class="min-h-[70vh] flex items-center justify-center py-8">
        <div class="w-full max-w-md space-y-6">

            <!-- Monogram & Header Brand -->
            <div class="text-center space-y-2">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-[#1E1A28] border border-[#3B2C52] flex items-center justify-center text-[#F2C58F] shadow-elevation">
                    <span class="material-symbols-outlined text-[32px]">shield_person</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-[#1E1A28]">
                    Portal Autentikasi Pustakawan
                </h1>
                <p class="text-xs text-[#7A7265] max-w-sm mx-auto">
                    Akses terproteksi pengelolaan katalog, kurasi koleksi, dan sirkulasi transaksi peminjaman Institut Teknologi Del.
                </p>
            </div>

            <!-- Login Card -->
            <div class="card-classy p-6 sm:p-8 space-y-5">
                <form action="{{ route('login.attempt') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#554D40] mb-1.5">
                            Email Dinas Pustakawan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-[18px] text-[#A89E8D]">mail</span>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $lastEmail ?? '') }}" 
                                   placeholder="pustakawan@del.ac.id" 
                                   class="form-control-classy w-full pl-9 pr-3 text-xs @error('email') border-red-500 @enderror" 
                                   required 
                                   autofocus>
                        </div>
                        @if($lastEmail && !old('email'))
                            <p class="text-[11px] text-[#9A5B18] mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">cookie</span>
                                <span>Alamat email terisi otomatis dari Cookie sesi sebelumnya.</span>
                            </p>
                        @endif
                        @error('email')
                            <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#554D40]">
                                Kata Sandi <span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-[18px] text-[#A89E8D]">lock</span>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   placeholder="••••••••••••" 
                                   class="form-control-classy w-full pl-9 pr-10 text-xs @error('password') border-red-500 @enderror" 
                                   required>
                            <button type="button" 
                                    onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';"
                                    class="absolute right-3 top-2.5 text-[#A89E8D] hover:text-[#312052] border-0 bg-transparent"
                                    title="Tampilkan / Sembunyikan Kata Sandi">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" 
                                   name="remember" 
                                   value="1" 
                                   {{ old('remember') ? 'checked' : '' }} 
                                   class="rounded border-[#DFD8CC] text-[#312052] focus:ring-[#312052]">
                            <span class="text-xs text-[#554D40] font-medium">Ingat Sesi di Perangkat Ini</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="btn-del w-full flex items-center justify-center gap-2 py-2.5 text-xs rounded-lg font-semibold shadow-sm hover:shadow">
                            <span class="material-symbols-outlined text-[17px]">login</span>
                            <span>Masuk ke Sistem Perpustakaan</span>
                        </button>
                    </div>

                </form>

                <!-- Official Test Account Card -->
                <div class="pt-4 border-t border-[#E8E1D5]">
                    <div class="p-3.5 rounded-xl bg-[#FAF0E4] border border-[#F3E1C8] text-xs text-[#9A5B18] space-y-1.5">
                        <div class="flex items-center gap-1.5 font-bold text-[#784411]">
                            <span class="material-symbols-outlined text-[16px] text-[#B4681E]">key</span>
                            <span>Kredensial Akun Pustakawan Uji (Sesuai Modul):</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 pt-1 font-mono text-[11px]">
                            <div class="bg-white/80 p-1.5 rounded border border-[#F3E1C8]">
                                <span class="block text-[9px] uppercase font-sans text-[#A56722] font-semibold">Email</span>
                                <span class="text-[#1E1A28] font-bold select-all">pustakawan@del.ac.id</span>
                            </div>
                            <div class="bg-white/80 p-1.5 rounded border border-[#F3E1C8]">
                                <span class="block text-[9px] uppercase font-sans text-[#A56722] font-semibold">Password</span>
                                <span class="text-[#1E1A28] font-bold select-all">password123</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Security Assurance Note -->
            <div class="text-center text-[11px] text-[#7A7265] flex items-center justify-center gap-1.5">
                <span class="material-symbols-outlined text-[15px] text-[#2D5F43]">lock</span>
                <span>Dilengkapi Regenerasi Sesi Anti-Fixation & Atribut Cookie HttpOnly</span>
            </div>

        </div>
    </div>
</x-layout>
