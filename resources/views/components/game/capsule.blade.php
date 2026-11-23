{{-- Kapsul ringkas: cover, judul, harga. Untuk baris rekomendasi. --}}
@props(['game'])
<a data-game-tip href="{{ route('games.show', $game->game_id) }}" class="group block overflow-hidden rounded-md border border-line bg-panel shadow-elev backdrop-blur-md transition duration-300 hover:-translate-y-1 hover:border-line-teal">
    <div class="relative aspect-video overflow-hidden">
        <x-game.cover :game="$game" class="h-full w-full transition duration-500 group-hover:scale-105" />
        <div class="pointer-events-none absolute inset-0 bg-linear-to-t from-deep/70 to-transparent to-45%"></div>
    </div>
    <div class="flex items-center justify-between gap-2 p-3">
        <span class="truncate text-sm font-bold">{{ $game->game_title }}</span>
        <x-game.price :game="$game" class="shrink-0" />
    </div>
    <x-game.tooltip :game="$game" />
</a>
