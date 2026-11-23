{{-- Satu baris keranjang. $item->game adalah objek game. --}}
@props(['item'])
<div class="flex items-center gap-4 border-b border-line py-4 last:border-b-0">
    <x-game.cover :game="$item->game" class="aspect-video w-28 shrink-0 rounded-sm" />
    <div class="min-w-0 flex-1">
        <a href="{{ route('games.show', $item->game->game_id) }}" class="font-extrabold hover:text-accent-2">{{ $item->game->game_title }}</a>
        <p class="truncate text-xs text-soft">{{ ($item->game->categories ?? collect())->pluck('category_name')->join(', ') }}</p>
    </div>
    <x-game.price :game="$item->game" />
    <form method="POST" action="{{ route('cart.destroy', $item->game->game_id) }}">
        @csrf
        @method('DELETE')
        <x-ui.button type="submit" variant="danger" size="sm">Hapus</x-ui.button>
    </form>
</div>
