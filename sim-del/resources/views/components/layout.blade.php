<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'SIPUS-Del' }} — Institut Teknologi Del</title>

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Material Symbols & Bootstrap Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS (Modul Praktikum Compliant) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS (Google Stitch Design System Tokens) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        surface: {
                            base: '#FAF8F5',
                            dim: '#EAE1DA',
                            card: '#FFFFFF',
                            low: '#FAF7F2'
                        },
                        del: {
                            midnight: '#1E1A28',
                            deep: '#2B213A',
                            plum: '#483660',
                            accent: '#4C1D95',
                            hover: '#3B0764',
                            border: '#E8E1D5'
                        },
                        amberClassy: {
                            badge: '#FDF8F0',
                            border: '#F3E1C8',
                            text: '#9A5B18',
                            accent: '#B4681E'
                        },
                        sage: {
                            badge: '#F2F7F4',
                            border: '#CCE3D6',
                            text: '#2D5F43',
                            accent: '#475E4E'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace']
                    },
                    boxShadow: {
                        'soft-card': '0 1px 3px rgba(30, 26, 41, 0.04), 0 6px 16px -4px rgba(30, 26, 41, 0.03)',
                        'subtle': '0 1px 2px rgba(0, 0, 0, 0.04)',
                        'elevation': '0 12px 32px -8px rgba(33, 27, 46, 0.08)'
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS Warm & Classy Academic Overlay -->
    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #FAF8F5;
            color: #24201D;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Modul Del Palette Overrides */
        .navbar-del {
            background-color: #1E1A28 !important;
            border-bottom: 1px solid #2F293F;
        }
        .btn-del {
            background-color: #312052 !important;
            border-color: #312052 !important;
            color: #ffffff !important;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
        }
        .btn-del:hover {
            background-color: #22143A !important;
            border-color: #22143A !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        .btn-del-outline {
            background-color: transparent !important;
            border: 1px solid #E8E1D5 !important;
            color: #2B213A !important;
            font-weight: 600;
        }
        .btn-del-outline:hover {
            background-color: #FAF7F2 !important;
            color: #1E1A28 !important;
        }
        .btn-del-amber {
            background-color: #B4681E !important;
            border-color: #B4681E !important;
            color: #ffffff !important;
        }
        .btn-del-amber:hover {
            background-color: #9A5B18 !important;
            color: #ffffff !important;
        }

        /* Academic Badges */
        .badge-kategori-classy {
            background-color: #FDF8F0;
            color: #9A5B18;
            border: 1px solid #F3E1C8;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
        }
        .badge-stok-tersedia {
            background-color: #F2F7F4;
            color: #2D5F43;
            border: 1px solid #CCE3D6;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
        }
        .badge-stok-habis {
            background-color: #FDF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
        }

        /* Form Controls Classy */
        .form-control-classy, .form-select-classy {
            background-color: #FAF8F5;
            border: 1px solid #DFD8CC;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            color: #24201D;
            transition: all 0.2s ease;
        }
        .form-control-classy:focus, .form-select-classy:focus {
            background-color: #FFFFFF;
            border-color: #483660;
            box-shadow: 0 0 0 3px rgba(72, 54, 96, 0.12);
            outline: none;
        }

        /* Card Classy */
        .card-classy {
            background: #FFFFFF;
            border: 1px solid #E8E1D5;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(30, 26, 41, 0.04), 0 6px 16px -4px rgba(30, 26, 41, 0.03);
        }

        .font-mono-code {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Pagination Del styling */
        .pagination .page-link {
            color: #312052;
            border-color: #E8E1D5;
            font-size: 13px;
            font-weight: 500;
        }
        .pagination .page-item.active .page-link {
            background-color: #312052;
            border-color: #312052;
            color: #ffffff;
        }
        .pagination .page-link:hover {
            background-color: #FAF7F2;
            color: #1E1A28;
        }
    </style>
</head>
<body class="bg-[#FAF8F5] text-[#24201D] font-sans antialiased selection:bg-[#EAE2F3] selection:text-[#2B213A]">

    <!-- Top Navigation Header: Del Heritage Aubergine with warm glow -->
    <header class="sticky top-0 w-full z-50 bg-[#1E1A28] border-b border-[#2F293F] text-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Brand & University Monogram Identity -->
            <div class="flex items-center gap-8">
                <a class="flex items-center gap-3.5 group no-underline" href="{{ url('/buku') }}">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#3B2C52] to-[#251F33] border border-white/10 flex items-center justify-center text-[#F2C58F] shadow-inner group-hover:border-white/20 transition-all">
                        <span class="material-symbols-outlined text-[23px]">local_library</span>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-[17px] tracking-tight text-white group-hover:text-[#F7E7CE] transition-colors">SIPUS-Del</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-white/10 text-white/80 font-mono tracking-wider font-semibold border border-white/5">v2.4</span>
                        </div>
                        <span class="text-[11px] font-medium tracking-wide text-white/60">Perpustakaan Institut Teknologi Del</span>
                    </div>
                </a>

                <!-- Main Navigation Pills -->
                <nav class="hidden lg:flex items-center gap-1.5 pl-2 border-l border-white/10">
                    <a class="px-3.5 py-2 rounded-lg text-[13px] font-semibold tracking-tight transition-colors no-underline flex items-center gap-1.5 {{ request()->is('buku*') || request()->is('/') ? 'bg-white/15 text-white border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}" 
                       href="{{ url('/buku') }}">
                        <span class="material-symbols-outlined text-[17px] text-[#E7C186]">menu_book</span>
                        <span>Katalog Buku</span>
                    </a>
                    
                    <a class="px-3.5 py-2 rounded-lg text-[13px] font-semibold tracking-tight transition-colors no-underline flex items-center gap-1.5 {{ request()->is('kategori*') ? 'bg-white/15 text-white border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}" 
                       href="{{ url('/kategori') }}">
                        <span class="material-symbols-outlined text-[17px] text-[#C07A28]">category</span>
                        <span>Kelola Kategori</span>
                    </a>

                    <a class="px-3.5 py-2 rounded-lg text-[13px] font-semibold tracking-tight transition-colors no-underline flex items-center gap-1.5 text-white/70 hover:text-white hover:bg-white/5" 
                       href="{{ url('/buku/create') }}">
                        <span class="material-symbols-outlined text-[17px] text-[#A3E635]">add_circle</span>
                        <span>Tambah Buku</span>
                    </a>
                </nav>
            </div>

            <!-- Header Tools & Librarian Profile Badge -->
            <div class="flex items-center gap-4">
                <a href="{{ url('/buku/create') }}" class="hidden sm:inline-flex items-center gap-1.5 bg-[#3B2C52] hover:bg-[#4A3766] text-[#F2C58F] border border-white/10 text-xs px-3.5 py-2 rounded-lg font-semibold transition-all no-underline shadow-sm">
                    <i class="bi bi-plus-lg"></i>
                    <span>Entri Cepat</span>
                </a>

                <!-- Librarian User Tag -->
                <div class="flex items-center gap-2.5 pl-2 border-l border-white/10">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#3F2F59] to-[#5C4580] border border-white/15 flex items-center justify-center text-white text-[13px] font-bold">
                        P
                    </div>
                    <div class="hidden xl:flex flex-col text-left">
                        <span class="text-[12px] font-semibold text-white leading-tight">Pustakawan Del</span>
                        <span class="font-mono text-[10px] text-white/50 tracking-wider">Laguboti, Toba</span>
                    </div>
                </div>
            </div>

        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow w-full py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Global Flash Notification Slot -->
            <x-flash-alert />

            <!-- Page Specific Content -->
            {{ $slot }}

        </div>
    </main>

    <!-- Academic Footer -->
    <footer class="w-full bg-[#1A1622] border-t border-[#2A2338] text-white/70 py-8 mt-12 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-[#F2C58F]">
                    <span class="material-symbols-outlined text-[17px]">account_balance</span>
                </div>
                <div>
                    <span class="font-bold text-white text-sm">SIPUS-Del</span> — 
                    <span class="text-xs text-white/60">Sistem Informasi Perpustakaan Institut Teknologi Del</span>
                </div>
            </div>

            <div class="text-xs text-center md:text-right text-white/50 space-y-1">
                <div>Jl. Sisingamangaraja, Sitoluama, Laguboti, Kabupaten Toba, Sumatera Utara 22381</div>
                <div>Praktikum Pemrograman & Pengujian Web (12S3101) &bull; Modul Minggu 05 Laravel 11 MVC</div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
