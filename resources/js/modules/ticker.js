// Pemberitahuan bergeser di header: item aktif naik keluar, item berikutnya naik dari bawah.
// Berhenti saat kursor atau fokus ada di atasnya dan saat tab tersembunyi.
// Tidak berputar bila pengguna meminta gerakan dikurangi.
// HTML: <div data-js="ticker" data-interval="4000"> <a data-ticker-item>...</a> ... </div>
const STATE = {
    idle: ['translate-y-full', 'opacity-0'],
    active: ['translate-y-0', 'opacity-100'],
    exit: ['-translate-y-full', 'opacity-0'],
};
const ALL = [...new Set(Object.values(STATE).flat())];

export default function ticker(el) {
    const items = [...el.querySelectorAll('[data-ticker-item]')];
    if (items.length < 2) return; // satu item saja: tampil tetap

    const interval = Number(el.dataset.interval ?? 4000);
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let current = 0;
    let timer = null;

    const setState = (item, state) => {
        item.classList.remove(...ALL);
        item.classList.add(...STATE[state]);
    };

    const next = () => {
        const target = (current + 1) % items.length;
        const incoming = items[target];

        // Taruh item masuk di bawah tanpa animasi, supaya selalu naik dari bawah.
        incoming.classList.add('transition-none');
        setState(incoming, 'idle');
        void incoming.offsetHeight; // paksa browser menerapkan posisi awal
        incoming.classList.remove('transition-none');

        setState(items[current], 'exit');
        setState(incoming, 'active');
        current = target;
    };

    const start = () => {
        if (reduced || timer) return;
        timer = setInterval(next, interval);
    };
    const stop = () => {
        clearInterval(timer);
        timer = null;
    };

    items.forEach((item, i) => setState(item, i === 0 ? 'active' : 'idle'));

    el.addEventListener('mouseenter', stop);
    el.addEventListener('mouseleave', start);
    el.addEventListener('focusin', stop);
    el.addEventListener('focusout', start);
    document.addEventListener('visibilitychange', () => (document.hidden ? stop() : start()));

    start();
}
