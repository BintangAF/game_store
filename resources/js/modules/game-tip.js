// Tooltip detail game saat kursor di atas kartu (hanya perangkat dengan kursor, lebar md ke atas).
// Kartu: atribut data-game-tip + <template data-game-tip-content> di dalamnya (komponen game/tooltip).
// Pemasangan: <body data-js="game-tip"> di layout. Satu tooltip dipakai bersama oleh semua kartu.
const BOX = 'pointer-events-none fixed left-0 top-0 z-[70] w-72 rounded-xl border border-line-teal bg-deep/95 p-4 opacity-0 shadow-elev backdrop-blur-lg transition-opacity duration-150';

export default function gameTip() {
    const canHover = window.matchMedia('(hover: hover) and (min-width: 768px)');
    const tip = document.createElement('div');
    tip.className = BOX;
    tip.setAttribute('role', 'tooltip');
    document.body.append(tip);

    let current = null;
    let timer = null;

    const place = (card) => {
        const gap = 12;
        const pad = 8;
        const r = card.getBoundingClientRect();
        const w = tip.offsetWidth;
        const h = tip.offsetHeight;

        let left = r.right + gap; // sisi kanan kartu
        if (left + w > window.innerWidth - pad) left = r.left - w - gap; // tidak muat: pindah ke kiri
        if (left < pad) left = Math.min(Math.max(pad, r.left), window.innerWidth - w - pad);

        const top = Math.max(pad, Math.min(r.top, window.innerHeight - h - pad));
        tip.style.transform = `translate(${left}px, ${top}px)`;
    };

    const show = (card) => {
        const template = card.querySelector('template[data-game-tip-content]');
        if (!template) return;
        tip.replaceChildren(template.content.cloneNode(true));
        current = card;
        place(card);
        tip.classList.replace('opacity-0', 'opacity-100');
    };

    const hide = () => {
        clearTimeout(timer);
        current = null;
        tip.classList.replace('opacity-100', 'opacity-0');
    };

    document.addEventListener('mouseover', (e) => {
        if (!canHover.matches) return;
        const card = e.target.closest('[data-game-tip]');
        if (!card || card === current) return;
        clearTimeout(timer);
        timer = setTimeout(() => show(card), 180);
    });

    document.addEventListener('mouseout', (e) => {
        const card = e.target.closest('[data-game-tip]');
        if (!card || card.contains(e.relatedTarget)) return;
        hide();
    });

    window.addEventListener('scroll', hide, { passive: true, capture: true });
    document.addEventListener('click', hide);
}
