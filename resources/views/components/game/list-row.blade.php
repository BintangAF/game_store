{{-- Baris daftar: cover kecil, judul, tag, tanggal rilis, harga. --}}
@props(['game'])
<a data-game-tip href="{{ route('games.show', $game->game_id) }}" class="group flex items-stretch gap-3 overflow-hidden rounded-md border border-line bg-panel shadow-elev backdrop-blur-md transition duration-300 hover:border-line-teal hover:bg-panel-2">
    <x-game.cover :game="$game" class="aspect-video w-32 shrink-0 sm:w-44" />
    <div class="flex min-w-0 flex-1 flex-col justify-center py-2 pr-3">
        <h3 class="truncate font-extrabold group-hover:text-accent-2">{{ $game->game_title }}</h3>
        <p class="truncate text-xs text-soft">{{ ($game->tags ?? collect())->pluck('tag_name')->join(', ') }}</p>
        <p class="text-xs text-soft">Dirilis: {{ \Illuminate\Support\Carbon::parse($game->release_date)->format('d/m/Y') }}</p>
    </div>
    <x-game.price :game="$game" class="shrink-0 justify-end pr-3" />
    <x-game.tooltip :game="$game" />
</a>
