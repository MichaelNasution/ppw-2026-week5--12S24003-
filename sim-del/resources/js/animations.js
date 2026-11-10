import { animate, stagger } from 'animejs';

/**
 * 1. Animasi Hitung Naik Angka Metrik (Count-Up Numbers)
 * Menggunakan tween integer Anime.js v4
 */
export function initMetricCounters() {
    const counterElements = document.querySelectorAll('[data-counter-target]');
    if (!counterElements.length) return;

    counterElements.forEach(el => {
        const targetValue = parseInt(el.getAttribute('data-counter-target'), 10) || 0;
        const obj = { val: 0 };

        animate(obj, {
            val: targetValue,
            round: 1,
            duration: 1100,
            ease: 'outExpo',
            onRender: () => {
                el.textContent = obj.val.toLocaleString('id-ID');
            }
        });
    });
}

/**
 * 2. Animasi Cascade Masuk Elemen Bertahap (Staggered Waterfall Entrance)
 */
export function initStaggeredEntrance(selector = '.stagger-item', delayStep = 35) {
    const items = document.querySelectorAll(selector);
    if (!items.length) return;

    animate(items, {
        opacity: [0, 1],
        translateY: [16, 0],
        delay: stagger(delayStep),
        duration: 480,
        ease: 'outQuad'
    });
}

/**
 * 3. Animasi Notifikasi Flash Session Toast & Pop-in
 */
export function animateFlashToast(elementId = 'flash-alert-container') {
    const el = document.getElementById(elementId) || document.querySelector('.flash-alert-item');
    if (!el) return;

    animate(el, {
        opacity: [0, 1],
        translateY: [-20, 0],
        scale: [0.97, 1],
        duration: 550,
        ease: 'outBack(1.4)'
    });
}

/**
 * 4. Animasi Tombol Salin ISBN ke Clipboard dengan Umpan Balik
 */
export function initCopyIsbnButtons() {
    document.querySelectorAll('.btn-copy-isbn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const isbn = btn.getAttribute('data-isbn');
            if (!isbn) return;

            navigator.clipboard.writeText(isbn).then(() => {
                // Micro-bounce animation Anime.js
                animate(btn, {
                    scale: [1, 1.15, 1],
                    duration: 320,
                    ease: 'outBack(2)'
                });

                const icon = btn.querySelector('.copy-icon');
                const text = btn.querySelector('.copy-text');
                const originalText = text ? text.textContent : '';

                if (icon) icon.textContent = 'check';
                if (text) text.textContent = 'Tersalin!';
                btn.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');

                setTimeout(() => {
                    if (icon) icon.textContent = 'content_copy';
                    if (text) text.textContent = originalText;
                    btn.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                }, 2000);
            }).catch(err => {
                console.warn('Gagal menyalin:', err);
            });
        });
    });
}

/**
 * 5. Keyboard Shortcut Pencarian (Tekan "/" untuk fokus ke input pencarian)
 */
export function initSearchShortcut() {
    const searchInput = document.querySelector('input[name="search"]');
    if (!searchInput) return;

    document.addEventListener('keydown', (e) => {
        // Jangan aktifkan jika user sedang mengetik di input/textarea lain
        if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
            return;
        }

        if (e.key === '/') {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();

            // Efek fokus halus Anime.js
            animate(searchInput.parentElement, {
                scale: [1, 1.02, 1],
                duration: 300,
                ease: 'outQuad'
            });
        }
    });
}

/**
 * 6. Live Monograph Preview pada Form Tambah/Edit Buku
 */
export function initLiveBookPreview() {
    const previewContainer = document.getElementById('book-live-preview');
    if (!previewContainer) return;

    const inputJudul = document.getElementById('judul');
    const inputPenulis = document.getElementById('penulis');
    const inputPenerbit = document.getElementById('penerbit');
    const inputTahun = document.getElementById('tahun_terbit');
    const inputIsbn = document.getElementById('isbn');
    const inputStok = document.getElementById('stok');
    const selectKategori = document.getElementById('kategori_id');

    const previewJudul = document.getElementById('preview-judul');
    const previewPenulis = document.getElementById('preview-penulis');
    const previewPenerbit = document.getElementById('preview-penerbit');
    const previewTahun = document.getElementById('preview-tahun');
    const previewIsbn = document.getElementById('preview-isbn');
    const previewKategori = document.getElementById('preview-kategori');
    const previewStok = document.getElementById('preview-stok');

    function updatePreview() {
        if (previewJudul && inputJudul) {
            previewJudul.textContent = inputJudul.value.trim() || 'Judul Monograf Buku';
        }
        if (previewPenulis && inputPenulis) {
            previewPenulis.textContent = inputPenulis.value.trim() || 'Nama Penulis';
        }
        if (previewPenerbit && inputPenerbit) {
            previewPenerbit.textContent = inputPenerbit.value.trim() || 'Penerbit IT Del';
        }
        if (previewTahun && inputTahun) {
            previewTahun.textContent = inputTahun.value.trim() || new Date().getFullYear();
        }
        if (previewIsbn && inputIsbn) {
            previewIsbn.textContent = inputIsbn.value.trim() || '978-0000000000';
        }
        if (previewStok && inputStok) {
            const val = parseInt(inputStok.value, 10);
            previewStok.textContent = isNaN(val) ? '0 Eks.' : val + ' Eks.';
        }
        if (previewKategori && selectKategori) {
            const selectedOpt = selectKategori.options[selectKategori.selectedIndex];
            previewKategori.textContent = selectedOpt && selectedOpt.value ? selectedOpt.text : 'Kategori Umum';
        }
    }

    [inputJudul, inputPenulis, inputPenerbit, inputTahun, inputIsbn, inputStok].forEach(input => {
        if (input) {
            input.addEventListener('input', updatePreview);
        }
    });

    if (selectKategori) {
        selectKategori.addEventListener('change', updatePreview);
    }
}

/**
 * 7. View Mode Switcher pada Katalog Buku (Table View vs Grid Cards View)
 */
export function initViewSwitcher() {
    const btnTable = document.getElementById('view-mode-table');
    const btnGrid = document.getElementById('view-mode-grid');
    const containerTable = document.getElementById('catalog-table-view');
    const containerGrid = document.getElementById('catalog-grid-view');

    if (!btnTable || !btnGrid || !containerTable || !containerGrid) return;

    function setViewMode(mode) {
        if (mode === 'grid') {
            containerTable.classList.add('hidden');
            containerGrid.classList.remove('hidden');

            btnGrid.classList.add('bg-[#312052]', 'text-white', 'shadow-sm');
            btnGrid.classList.remove('text-[#786E60]', 'hover:bg-[#F3EFE9]');

            btnTable.classList.remove('bg-[#312052]', 'text-white', 'shadow-sm');
            btnTable.classList.add('text-[#786E60]', 'hover:bg-[#F3EFE9]');

            // Trigger animation on grid cards
            animate(containerGrid.querySelectorAll('.catalog-card-item'), {
                opacity: [0, 1],
                translateY: [16, 0],
                delay: stagger(35),
                duration: 420,
                ease: 'outQuad'
            });

            localStorage.setItem('sipus_view_mode', 'grid');
        } else {
            containerGrid.classList.add('hidden');
            containerTable.classList.remove('hidden');

            btnTable.classList.add('bg-[#312052]', 'text-white', 'shadow-sm');
            btnTable.classList.remove('text-[#786E60]', 'hover:bg-[#F3EFE9]');

            btnGrid.classList.remove('bg-[#312052]', 'text-white', 'shadow-sm');
            btnGrid.classList.add('text-[#786E60]', 'hover:bg-[#F3EFE9]');

            // Trigger animation on table rows
            animate(containerTable.querySelectorAll('tbody tr'), {
                opacity: [0, 1],
                translateY: [12, 0],
                delay: stagger(30),
                duration: 380,
                ease: 'outQuad'
            });

            localStorage.setItem('sipus_view_mode', 'table');
        }
    }

    btnTable.addEventListener('click', () => setViewMode('table'));
    btnGrid.addEventListener('click', () => setViewMode('grid'));

    // Muat preferensi terakhir
    const savedMode = localStorage.getItem('sipus_view_mode') || 'table';
    if (savedMode === 'grid') {
        setViewMode('grid');
    }
}
