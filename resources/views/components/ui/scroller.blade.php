{{--
  Baris yang bisa digeser: tombol kiri/kanan di desktop, swipe di HP, titik halaman di bawah.
  Isi slot = item. Desktop menampilkan 5 item sekaligus. JS: resources/js/modules/scroller.js
--}}
<div data-js="scroller" {{ $attributes->merge(['class' => 'relative']) }}>
    <div data-scroller-track class="flex snap-x snap-mandatory gap-3 overflow-x-auto scroll-smooth pb-1 [scrollbar-width:none] [&>*]:shrink-0 [&>*]:basis-40 [&>*]:snap-start md:[&>*]:basis-[calc((100%_-_3rem)/5)]">
        {{ $slot }}
    </div>
    <button type="button" data-scroller-prev aria-label="Geser ke kiri"
            class="absolute left-2 top-[calc(50%_-_0.5rem)] hidden size-10 -translate-y-1/2 place-items-center rounded-full border border-line-teal bg-deep/80 text-xl backdrop-blur transition hover:bg-accent-2/20 disabled:pointer-events-none disabled:opacity-0 md:grid">&lsaquo;</button>
    <button type="button" data-scroller-next aria-label="Geser ke kanan"
            class="absolute right-2 top-[calc(50%_-_0.5rem)] hidden size-10 -translate-y-1/2 place-items-center rounded-full border border-line-teal bg-deep/80 text-xl backdrop-blur transition hover:bg-accent-2/20 disabled:pointer-events-none disabled:opacity-0 md:grid">&rsaquo;</button>
    <div data-scroller-dots class="mt-3 flex justify-center gap-1.5"></div>
</div>
