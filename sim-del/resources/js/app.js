import './bootstrap';
import { 
    initMetricCounters, 
    initStaggeredEntrance, 
    animateFlashToast, 
    initCopyIsbnButtons, 
    initSearchShortcut, 
    initLiveBookPreview, 
    initViewSwitcher 
} from './animations';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Inisialisasi hitung naik metrik
    initMetricCounters();

    // 2. Inisialisasi animasi masuk bertahap (Staggered Waterfall)
    initStaggeredEntrance('.stagger-item', 35);

    // 3. Inisialisasi pop-in notifikasi flash
    animateFlashToast();

    // 4. Inisialisasi tombol salin ISBN
    initCopyIsbnButtons();

    // 5. Inisialisasi pintasan keyboard "/"
    initSearchShortcut();

    // 6. Inisialisasi pratinjau buku langsung pada form
    initLiveBookPreview();

    // 7. Inisialisasi toggle tampilan tabel vs kartu grid
    initViewSwitcher();
});
