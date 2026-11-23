{{-- Kartu dengan deretan tag di bawah cover. --}}
@props(['game'])
<a data-game-tip href="{{ route('games.show', $game->game_id) }}" class="group block overflow-hidden rounded-md border border-line bg-panel shadow-elev backdrop-blur-md transition duration-300 hover:-translate-y-1 hover:border-line-teal">
    <div class="relative aspect-video overflow-hidden">
        <x-game.cover :game="$game" class="h-full w-full transition duration-500 group-hover:scale-105" />
        <div class="pointer-events-none absolute inset-0 bg-linear-to-t from-deep/70 to-transparent to-45%"></div>
    </div>
    <div class="flex flex-wrap gap-1.5 px-3 pt-3">
        @foreach (($game->tags ?? collect())->take(4) as $tag)
            <x-ui.chip tone="tag">{{ $tag->tag_name }}</x-ui.chip>
        @endforeach
    </div>
    <x-game.price :game="$game" class="p-3" />
    <x-game.tooltip :game="$game" />
</a>
