export default function headerScroll(header) {
    const topHeader = header.querySelector('[data-header-top]');
    const storeNav = header.querySelector('[data-header-store]');

    if (!topHeader || !storeNav) return;

    let lastScrollY = window.scrollY;
    let ticking = false;

    // Menyiapkan animasi kedua bagian.
    // overflow dibiarkan 'visible' saat diam supaya dropdown tidak terpotong.
    // Hanya 'hidden' selama animasi buka/tutup.
    function prepare(element) {
        element.style.overflow = 'visible';
        element.style.maxHeight = `${element.scrollHeight}px`;
        element.style.opacity = '1';
        element.style.transform = 'translateY(0)';
        element.style.transition =
            'max-height 0.35s ease, opacity 0.25s ease, transform 0.35s ease';

        element.addEventListener('transitionend', (e) => {
            if (e.propertyName === 'max-height' && element.style.maxHeight !== '0px') {
                element.style.overflow = 'visible';
            }
        });
    }

    function hide(element) {
        element.style.overflow = 'hidden';
        element.style.maxHeight = '0px';
        element.style.opacity = '0';
        element.style.transform = 'translateY(-12px)';
    }

    function show(element) {
        if (element.style.maxHeight === '0px') element.style.overflow = 'hidden';
        element.style.maxHeight = `${element.scrollHeight}px`;
        element.style.opacity = '1';
        element.style.transform = 'translateY(0)';
    }

    prepare(topHeader);
    prepare(storeNav);

    let topHidden = false;
    let navHidden = false;

    // Jeda (posisi scroll dalam px) -- ubah angka ini untuk mengatur kapan header bergerak.
    const HIDE_TOP_AT = 150;   // scroll turun: header atas hilang duluan di posisi ini
    const HIDE_NAV_AT = 400;   // scroll turun: setelah itu navigasi toko ikut hilang
    const SHOW_TOP_AT = 10;    // scroll naik: header atas baru muncul saat mentok di atas

    function handleScroll() {
        const currentY = window.scrollY;
        const scrollingDown = currentY > lastScrollY + 5;
        const scrollingUp = currentY < lastScrollY - 5;

        // Mentok di atas: semuanya ditampilkan
        if (currentY <= SHOW_TOP_AT) {
            if (topHidden) {
                topHidden = false;
                show(topHeader);
            }
            if (navHidden) {
                navHidden = false;
                show(storeNav);
            }
        }

        // Scroll ke bawah
        else if (scrollingDown) {

            // Tahap 1: sembunyikan header atas
            if (currentY > HIDE_TOP_AT && !topHidden) {
                topHidden = true;
                hide(topHeader);
            }

            // Tahap 2: scroll lebih jauh, sembunyikan navigasi toko
            if (currentY >= HIDE_NAV_AT && !navHidden) {
                navHidden = true;
                hide(storeNav);
            }
        }

        // Scroll ke atas
        else if (scrollingUp) {

            // Navigasi toko muncul lebih dulu. Header atas menunggu sampai mentok di atas.
            if (navHidden) {
                navHidden = false;
                show(storeNav);
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