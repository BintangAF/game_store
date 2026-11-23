// Tab: klik tombol [data-tab="nama"] untuk menampilkan panel [data-panel="nama"].
// HTML: <div data-js="tabs"> ... </div>
const ON = ['bg-accent', 'text-fg', 'border-accent', 'shadow-glow-red'];
const OFF = ['bg-panel', 'text-muted', 'border-line'];

export default function tabs(el) {
    const buttons = el.querySelectorAll('[data-tab]');
    const panels = el.querySelectorAll('[data-panel]');

    const show = (name) => {
        buttons.forEach((b) => {
            const active = b.dataset.tab === name;
            b.setAttribute('aria-selected', active);
            b.classList.remove(...(active ? OFF : ON));
            b.classList.add(...(active ? ON : OFF));
        });
        panels.forEach((p) => p.classList.toggle('hidden', p.dataset.panel !== name));
    };

    buttons.forEach((b) => b.addEventListener('click', () => show(b.dataset.tab)));
    if (buttons[0]) show(buttons[0].dataset.tab);
}
