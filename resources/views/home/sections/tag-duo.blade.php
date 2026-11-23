{{-- Dua blok kategori, masing-masing 4 game. Data: $tagBlocks (id, name, games). --}}
<div class="mt-10 grid gap-8 md:grid-cols-2">
    @foreach ($tagBlocks as $block)
        <div>
            <p class="text-[0.72rem] font-extrabold uppercase tracking-[2px] text-accent-2">Sesuai game yang kamu mainkan</p>
            <h2 class="mb-4 text-[1.4rem] font-black tracking-tight">{{ $block->name }}</h2>
            <div class="grid grid-cols-2 gap-3">
                @foreach ($block->games as $game)
                    <x-game.capsule :game="$game" />
                @endforeach
            </div>
            <div class="mt-4 text-right">
                <x-ui.button :href="route('search', ['category' => $block->id])" variant="outline" size="sm">Lebih banyak lagi</x-ui.button>
            </div>
        </div>
    @endforeach
</div>
