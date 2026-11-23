// Baris yang bisa digeser: tombol kiri/kanan, titik halaman, dan swipe (native).
// HTML: <div data-js="scroller"> [data-scroller-track] [data-scroller-prev] [data-scroller-next] [data-scroller-dots]
const DOT_ON = ['w-6', 'bg-accent'];
const DOT_OFF = ['w-2', 'bg-fg/40'];

export default function scroller(el) {
    const track = el.querySelector('[data-scroller-track]');
    const prev = el.querySelector('[data-scroller-prev]');
    const next = el.querySelector('[data-scroller-next]');
    const dotsBox = el.querySelector('[data-scroller-dots]');
    if (!track) return;

    let dots = [];

    const pages = () => Math.max(1, Math.ceil((track.scrollWidth - 2) / track.clientWidth));
    const maxScroll = () => track.scrollWidth - track.clientWidth;
    const page = () => (track.scrollLeft >= maxScroll() - 2 ? pages() - 1 : Math.round(track.scrollLeft / track.clientWidth));

    const buildDots = () => {
        if (!dotsBox) return;
        dotsBox.replaceChildren();
        dots = Array.from({ length: pages() }, (_, k) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.setAttribute('aria-label', `Halaman ${k + 1}`);
            dot.className = 'h-2 rounded-full transition-all';
            dot.addEventListener('click', () => track.scrollTo({ left: k * track.clientWidth, behavior: 'smooth' }));
            dotsBox.append(dot);
            return dot;
        });
        dotsBox.classList.toggle('hidden', dots.length < 2);
    };

    const update = () => {
        const current = page();
        dots.forEach((d, k) => {
            d.classList.remove(...(k === current ? DOT_OFF : DOT_ON));
            d.classList.add(...(k === current ? DOT_ON : DOT_OFF));
        });
        if (prev) prev.disabled = track.scrollLeft <= 2;
        if (next) next.disabled = track.scrollLeft >= maxScroll() - 2;
    };

    prev?.addEventListener('click', () => track.scrollBy({ left: -track.clientWidth, behavior: 'smooth' }));
    next?.addEventListener('click', () => track.scrollBy({ left: track.clientWidth, behavior: 'smooth' }));

    let frame;
    track.addEventListener('scroll', () => {
        cancelAnimationFrame(frame);
        frame = requestAnimationFrame(update);
    }, { passive: true });
    window.addEventListener('resize', () => {
        buildDots();
        update();
    });

    buildDots();
    update();
}
