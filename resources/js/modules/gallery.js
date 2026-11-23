// Galeri: klik thumbnail [data-gallery-thumb="i"] untuk menampilkan slide [data-gallery-slide="i"].
// HTML: <div data-js="gallery"> ... </div>
export default function gallery(el) {
    const thumbs = el.querySelectorAll('[data-gallery-thumb]');
    const slides = el.querySelectorAll('[data-gallery-slide]');

    const show = (i) => {
        slides.forEach((s) => s.classList.toggle('hidden', s.dataset.gallerySlide !== i));
        thumbs.forEach((t) => {
            const active = t.dataset.galleryThumb === i;
            t.classList.toggle('border-accent-2', active);
            t.classList.toggle('opacity-100', active);
            t.classList.toggle('border-transparent', !active);
            t.classList.toggle('opacity-70', !active);
        });
    };

    thumbs.forEach((t) => t.addEventListener('click', () => show(t.dataset.galleryThumb)));
    if (thumbs[0]) show(thumbs[0].dataset.galleryThumb);
}
