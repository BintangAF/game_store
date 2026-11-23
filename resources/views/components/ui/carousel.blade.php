{{--
  Carousel: loop tanpa ujung, geser otomatis, dan slide sebelum/sesudahnya terlihat sedikit di kiri dan kanan.
  Isi slot = slide (satu elemen per slide). Klik slide samping untuk pindah ke sana.
  JS: resources/js/modules/carousel.js. Atribut: autoplay = jeda geser dalam ms (0 untuk mematikan).
--}}
@props(['autoplay' => 5000])
<div data-js="carousel" data-autoplay="{{ $autoplay }}" {{ $attributes->merge(['class' => 'relative']) }}>
    {{-- Viewport selebar layar supaya slide samping terlihat di luar kolom konten. --}}
    <div data-carousel-viewport class="relative left-1/2 -my-6 w-screen -translate-x-1/2 overflow-hidden py-6">
        <div data-carousel-track class="flex gap-4 will-change-transform [&>*]:shrink-0 [&>*]:transition [&>*]:duration-500">
            {{ $slot }}
        </div>
    </div>

    {{-- Kontrol di pojok kanan bawah slide aktif supaya tidak menimpa teks di sisi kiri. --}}
    <div class="absolute bottom-5 right-5 z-20 flex items-center gap-3">
        <div data-carousel-dots class="flex items-center gap-1.5"></div>
        <div class="hidden gap-2 md:flex">
            <button type="button" data-carousel-prev aria-label="Sebelumnya"
                    class="grid size-10 place-items-center rounded-full border border-line-teal bg-deep/80 text-xl backdrop-blur transition hover:bg-accent-2/20">&lsaquo;</button>
            <button type="button" data-carousel-next aria-label="Berikutnya"
                    class="grid size-10 place-items-center rounded-full border border-line-teal bg-deep/80 text-xl backdrop-blur transition hover:bg-accent-2/20">&rsaquo;</button>
        </div>
    </div>
</div>
