// Pemasang modul: cari elemen ber-atribut data-js="nama" lalu jalankan modul bernama itu.
// Contoh HTML: <div data-js="carousel" data-autoplay="6000"> ... </div>
const registry = {};

export function register(name, init) {
    registry[name] = init;
}

export function bootAll(root = document) {
    root.querySelectorAll('[data-js]').forEach((el) => {
        el.dataset.js.split(' ').forEach((name) => {
            if (!registry[name]) return;
            registry[name](el);
        });
    });
}
