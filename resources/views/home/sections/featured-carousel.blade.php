{{-- Banner rekomendasi (carousel berjalan). Data: $featured (5-6 game). JS: carousel. --}}
<x-ui.carousel>
    @foreach ($featured as $game)
        <article class="relative flex min-h-[340px] items-end overflow-hidden rounded-lg border border-line bg-deep shadow-elev md:min-h-[400px]">
            <x-game.cover :game="$game" class="absolute inset-0 h-full w-full" />
            <div class="absolute inset-0 bg-linear-to-r from-deep/95 via-deep/65 to-deep/15"></div>
            <div class="absolute inset-0 bg-linear-to-t from-deep/90 to-transparent to-55%"></div>

            <div class="relative z-10 flex max-w-xl flex-col gap-3 p-6 md:p-8">
                <x-ui.badge>Rekomendasi</x-ui.badge>
                <h3 class="text-3xl font-black leading-tight tracking-tight [text-shadow:0_4px_20px_rgb(0_0_0/0.5)] md:text-[2.3rem]">{{ $game->game_title }}</h3>
                <p class="line-clamp-2 max-w-lg text-sm text-muted">{{ $game->game_desc ?? '' }}</p>
                <div class="flex flex-wrap items-center gap-4">
                    <x-game.rating :average="$game->reviews_avg_star ?? null" :count="$game->reviews_count ?? 0" />
                    <x-game.price :game="$game" />
                </div>
                <div class="flex gap-2">
                    <x-ui.button :href="route('games.show', $game->game_id)">Lihat detail</x-ui.button>
                </div>
            </div>
        </article>
    @endforeach
</x-ui.carousel>
