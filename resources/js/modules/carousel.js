// Carousel loop tanpa ujung, geser otomatis, dengan slide samping terlihat sebagai preview.
// Cara kerja: slide pertama dan terakhir diklon di ujung lawan. Setelah animasi sampai di klon,
// posisi dipindah tanpa animasi ke slide asli, jadi putarannya terlihat mulus.
// HTML: <div data-js="carousel" data-autoplay="5000"> [data-carousel-viewport] [data-carousel-track] [data-carousel-dots] [data-carousel-prev] [data-carousel-next]
const DURATION = 500; // ms, samakan dengan duration-500 di komponen
const GAP = 16; // px, samakan dengan gap-4 di komponen
const DOT_ON = ['w-6', 'bg-accent'];
const DOT_OFF = ['w-2', 'bg-fg/40'];
const SIDE = ['opacity-45', 'grayscale', 'scale-95', 'cursor-pointer']; // gaya slide samping

export default function carousel(el) {
    const viewport = el.querySelector('[data-carousel-viewport]');
    const track = el.querySelector('[data-carousel-track]');
    if (!viewport || !track) return;

    const originals = [...track.children];
    const total = originals.length;
    if (total < 2) return;

    // Klon untuk loop. Klon disembunyikan dari pembaca layar dan urutan Tab.
    const cloneOf = (node) => {
        const copy = node.cloneNode(true);
        copy.setAttribute('aria-hidden', 'true');
        copy.querySelectorAll('a, button').forEach((x) => (x.tabIndex = -1));
        return copy;
    };
    track.prepend(cloneOf(originals[total - 1]));
    track.append(cloneOf(originals[0]));
    const items = [...track.children]; // klon terakhir, slide asli 1..total, klon pertama

    // Titik penanda
    const dotsBox = el.querySelector('[data-carousel-dots]');
    const dots = originals.map((_, k) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.setAttribute('aria-label', `Slide ${k + 1}`);
        dot.className = 'h-2 rounded-full transition-all';
        dot.addEventListener('click', () => go(k + 1));
        dotsBox?.append(dot);
        return dot;
    });

    let index = 1; // posisi di track
    let locked = false;
    let timer = null;

    // Slide selebar kolom konten, slide aktif di tengah viewport.
    const layout = (animate) => {
        const width = el.clientWidth;
        items.forEach((s) => (s.style.width = `${width}px`));
        const x = (viewport.clientWidth - width) / 2 - index * (width + GAP);
        track.style.transition = animate ? `transform ${DURATION}ms ease` : 'none';
        track.style.transform = `translateX(${x}px)`;
    };

    const mark = () => {
        items.forEach((s, p) => SIDE.forEach((c) => s.classList.toggle(c, p !== index)));
        const real = (index - 1 + total) % total;
        dots.forEach((d, k) => {
            d.classList.remove(...(k === real ? DOT_OFF : DOT_ON));
            d.classList.add(...(k === real ? DOT_ON : DOT_OFF));
        });
    };

    const move = (i, animate = true) => {
        index = i;
        layout(animate);
        mark();
    };

    const go = (i) => {
        if (locked) return;
        locked = true;
        move(i);
        setTimeout(() => {
            if (index === total + 1) move(1, false);
            else if (index === 0) move(total, false);
            locked = false;
        }, DURATION + 20);
    };

    el.querySelector('[data-carousel-prev]')?.addEventListener('click', () => go(index - 1));
    el.querySelector('[data-carousel-next]')?.addEventListener('click', () => go(index + 1));

    // Klik slide samping: pindah ke slide itu, bukan membuka tautannya.
    track.addEventListener('click', (e) => {
        const p = items.findIndex((s) => s.contains(e.target));
        if (p === -1 || p === index) return;
        e.preventDefault();
        e.stopPropagation();
        go(p);
    }, true);

    // Geser otomatis. Berhenti saat kursor atau fokus ada di carousel, saat tab tersembunyi,
    // dan tidak jalan bila pengguna meminta gerakan dikurangi.
    const delay = Number(el.dataset.autoplay ?? 5000);
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const start = () => {
        if (!delay || reduced || timer) return;
        timer = setInterval(() => go(index + 1), delay);
    };
    const stop = () => {
        clearInterval(timer);
        timer = null;
    };

    el.addEventListener('mouseenter', stop);
    el.addEventListener('mouseleave', start);
    el.addEventListener('focusin', stop);
    el.addEventListener('focusout', start);
    document.addEventListener('visibilitychange', () => (document.hidden ? stop() : start()));

    // Swipe di layar sentuh
    let startX = null;
    track.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        stop();
    }, { passive: true });
    track.addEventListener('touchend', (e) => {
        if (startX !== null) {
            const dx = e.changedTouches[0].clientX - startX;
            if (Math.abs(dx) > 40) go(index + (dx < 0 ? 1 : -1));
        }
        startX = null;
        start();
    });

    window.addEventListener('resize', () => layout(false));

    move(1, false);
    start();
}
