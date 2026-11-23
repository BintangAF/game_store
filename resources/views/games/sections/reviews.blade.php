{{--
  Data: $reviews (paginator, 5 per halaman, nama halaman "ulasan"), $ratingBreakdown ([5 => jumlah, ..., 1 => jumlah]),
        $reviewAccess ('guest' | 'must_buy' | 'allowed' | 'reviewed'), $game (reviews_count, reviews_avg_star).
  Rata-rata dan jumlah dihitung backend dari semua ulasan, bukan dari 5 yang tampil.
  Ulasan hanya bisa ditulis pembeli: backend menentukan $reviewAccess dan menolak POST dari non-pembeli.
--}}
@php
    $access = $reviewAccess ?? 'guest';
@endphp
<x-ui.panel id="ulasan">
    <h2 class="mb-4 text-lg font-black">Ulasan dan rating</h2>

    <x-review.summary :average="$game->reviews_avg_star ?? 0" :count="$game->reviews_count ?? 0" :breakdown="$ratingBreakdown ?? []" />

    <div class="mt-5 border-t border-line pt-4">
        @forelse ($reviews as $review)
            <x-review.item :review="$review" />
        @empty
            <p class="text-sm text-soft">Belum ada ulasan untuk game ini.</p>
        @endforelse

        @if (method_exists($reviews, 'hasPages'))
            {{ $reviews->links('partials.pagination') }}
        @endif
    </div>

    <div class="mt-5 border-t border-line pt-4">
        @if ($access === 'allowed')
            <x-review.form :game="$game" />
        @elseif ($access === 'reviewed')
            <p class="text-sm text-soft">Kamu sudah menulis ulasan untuk game ini.</p>
        @elseif ($access === 'must_buy')
            <p class="text-sm text-soft">Beli game ini untuk menulis ulasan dan memberi rating.</p>
        @else
            <p class="text-sm text-soft">Masuk dan beli game ini untuk menulis ulasan. <a href="{{ route('login') }}" class="text-accent-2 hover:underline">Masuk</a></p>
        @endif
    </div>
</x-ui.panel>
