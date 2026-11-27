
export default function headerScroll(header) {
    const topHeader = header.querySelector('[data-header-top]');
    const storeNav = header.querySelector('[data-header-store]');

    if (!topHeader || !storeNav) return;

    let lastScrollY = window.scrollY;
    let ticking = false;

    // Menyiapkan animasi kedua bagian
    function prepare(element) {
        element.style.overflow = 'hidden';
        element.style.maxHeight = `${element.scrollHeight}px`;
        element.style.opacity = '1';
        element.style.transform = 'translateY(0)';
        element.style.transition =
            'max-height 0.35s ease, opacity 0.25s ease, transform 0.35s ease';
    }

    function hide(element) {
        element.style.maxHeight = '0px';
        element.style.opacity = '0';
        element.style.transform = 'translateY(-12px)';
    }

    function show(element) {
        element.style.maxHeight = `${element.scrollHeight}px`;
        element.style.opacity = '1';
        element.style.transform = 'translateY(0)';
    }

    prepare(topHeader);
    prepare(storeNav);

    let topHidden = false;
    let navHidden = false;

    function handleScroll() {
        const currentY = window.scrollY;
        const scrollingDown = currentY > lastScrollY + 5;
        const scrollingUp = currentY < lastScrollY - 5;

        // Posisi paling atas: semuanya ditampilkan
        if (currentY <= 10) {
            topHidden = false;
            navHidden = false;

            show(topHeader);
            show(storeNav);
        }

        // Scroll ke bawah
        else if (scrollingDown) {

            // Tahap 1: sembunyikan navigasi toko
            if (currentY > 150 && !navHidden) {
                navHidden = true;
                hide(storeNav);
            }

            // Tahap 2: scroll lebih jauh, sembunyikan header atas
            if (currentY >= 350 && !topHidden) {
                topHidden = true;
                hide(topHeader);
            }
        }

        // Scroll ke atas
        else if (scrollingUp) {

            // Navbar toko muncul terlebih dahulu
            if (navHidden) {
                navHidden = false;
                show(storeNav);
            }

            // Header atas baru muncul ketika mendekati puncak
            if (currentY <= 120 && topHidden) {
                topHidden = false;
                show(topHeader);
            }
        }

        lastScrollY = currentY;
        ticking = false;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(handleScroll);
            ticking = true;
        }
    }, { passive: true });

    window.addEventListener('resize', () => {
        if (!topHidden) show(topHeader);
        if (!navHidden) show(storeNav);
    });
}
