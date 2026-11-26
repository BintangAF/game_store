{{--
  Pemberitahuan yang bergeser di header: satu per satu, naik ke atas, berputar tanpa ujung.
  Tiap item: label (teks lencana), tone (accent | sage | muted), text, href.
  Data: $headerNotices (dibagikan ke semua view, lihat app/Support/HeaderNotices.php).
  JS: resources/js/modules/ticker.js. Kosong = tidak ditampilkan.
--}}
@props(['items' => []])
@if (count($items))
    <div data-js="ticker" data-interval="4000" role="region" aria-label="Pemberitahuan"
         {{ $attributes->merge(['class' => 'relative h-9 overflow-hidden rounded-full border border-line-teal bg-accent-2/10']) }}>
        @foreach ($items as $item)
            {{-- Item pertama tampil dulu. Sisanya menunggu di bawah. JS yang mengatur giliran. --}}
            <a href="{{ $item['href'] ?? '#' }}" data-ticker-item
               class="absolute inset-0 flex items-center gap-2.5 px-4 text-sm transition duration-500 hover:text-accent-2 {{ $loop->first ? 'translate-y-0 opacity-100' : 'translate-y-full opacity-0' }}">
                <x-ui.badge :tone="$item['tone'] ?? 'sage'" class="shrink-0">{{ $item['label'] ?? '' }}</x-ui.badge>
                <span class="truncate">{{ $item['text'] ?? '' }}</span>
            </a>
        @endforeach
    </div>
@endif
