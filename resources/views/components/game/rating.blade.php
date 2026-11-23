{{-- <x-game.rating :average="$game->reviews_avg_star" :count="$game->reviews_count" /> --}}
@props(['average' => null, 'count' => 0])
<p {{ $attributes->merge(['class' => 'text-sm text-soft']) }}>
    @if ($count > 0)
        <span class="font-bold text-accent-2">&#9733; {{ number_format($average, 1, ',', '.') }}</span> ({{ $count }} ulasan)
    @else
        Belum ada ulasan
    @endif
</p>
