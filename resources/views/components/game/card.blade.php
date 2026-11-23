{{-- Kartu standar: cover, rating, judul, chip, harga. Tombol hati = tambah ke wishlist. :wish="false" untuk menyembunyikannya. --}}
@props(['game', 'wish' => true])
<article data-game-tip class="group flex flex-col overflow-hidden rounded-md border border-line bg-panel shadow-elev backdrop-blur-md transition duration-300 hover:-translate-y-1.5 hover:border-line-teal">
    <div class="relative aspect-video overflow-hidden">
        <a href="{{ route('games.show', $game->game_id) }}" class="block h-full" tabindex="-1" aria-hidden="true">
            <x-game.cover :game="$game" class="h-full w-full transition duration-500 group-hover:scale-105" />
        </a>
        <div class="pointer-events-none absolute inset-0 bg-linear-to-t from-deep/70 to-transparent to-45%"></div>
        @if (($game->reviews_count ?? 0) > 0)
            <span class="absolute left-2.5 top-2.5 rounded-full border border-line-teal bg-deep/80 px-2.5 py-0.5 text-xs font-extrabold text-accent-2 backdrop-blur">&#9733; {{ number_format($game->reviews_avg_star, 1, ',', '.') }}</span>
        @endif
        @if ($wish)
            <form method="POST" action="{{ route('wishlist.store') }}" class="absolute right-2.5 top-2.5">
                @csrf
                <input type="hidden" name="game_id" value="{{ $game->game_id }}">
                <button type="submit" aria-label="Tambah ke wishlist"
                        class="grid size-8 place-items-center rounded-full border border-line bg-deep/80 text-sm backdrop-blur transition hover:scale-110 hover:border-accent hover:bg-accent">&#9825;</button>
            </form>
        @endif
    </div>

    <div class="flex flex-1 flex-col gap-2 p-4">
        <h3 class="text-[1.08rem] font-extrabold"><a href="{{ route('games.show', $game->game_id) }}" class="hover:text-accent-2">{{ $game->game_title }}</a></h3>
        <p class="text-xs text-soft">{{ $game->developer_name ?? '' }}</p>
        <div class="flex flex-wrap gap-1.5">
            @foreach (($game->categories ?? collect())->take(2) as $category)
                <x-ui.chip>{{ $category->category_name }}</x-ui.chip>
            @endforeach
            @foreach (($game->tags ?? collect())->take(2) as $tag)
                <x-ui.chip tone="tag">{{ $tag->tag_name }}</x-ui.chip>
            @endforeach
        </div>
        <div class="mt-auto flex items-center justify-between gap-2 border-t border-line pt-3">
            <x-game.price :game="$game" />
            <x-ui.button :href="route('games.show', $game->game_id)" variant="outline" size="sm">Detail</x-ui.button>
        </div>
    </div>
    <x-game.tooltip :game="$game" />
</article>
