{{-- Kotak beli. Data: $game, $owned, $inCart, $wishlisted. --}}
@php
    $rows = [
        'Pengembang' => $game->developer_name,
        'Penerbit' => $game->publisher_name,
        'Rilis' => \Illuminate\Support\Carbon::parse($game->release_date)->format('d/m/Y'),
        'Kategori' => ($game->categories ?? collect())->pluck('category_name')->join(', '),
    ];
@endphp
<x-ui.panel class="lg:sticky lg:top-36">
    <x-game.cover :game="$game" class="aspect-video w-full rounded-sm" />

    <dl class="mt-4 text-sm">
        @foreach ($rows as $label => $value)
            <div class="flex justify-between gap-4 border-b border-line py-2">
                <dt class="font-semibold text-soft">{{ $label }}</dt>
                <dd class="text-right">{{ $value }}</dd>
            </div>
        @endforeach
    </dl>

    <x-game.price :game="$game" class="mt-4 text-lg" />

    <div class="mt-4 space-y-2">
        @if ($owned ?? false)
            <x-ui.button :href="route('collection')" variant="outline" block>Sudah dimiliki, buka koleksi</x-ui.button>
        @elseif ($inCart ?? false)
            <x-ui.button :href="route('cart')" variant="teal" block>Sudah di keranjang, lihat keranjang</x-ui.button>
        @else
            <form method="POST" action="{{ route('cart.store') }}">
                @csrf
                <input type="hidden" name="game_id" value="{{ $game->game_id }}">
                <x-ui.button type="submit" block>Tambah ke keranjang</x-ui.button>
            </form>
        @endif

        @if ($wishlisted ?? false)
            <form method="POST" action="{{ route('wishlist.destroy', $game->game_id) }}">
                @csrf
                @method('DELETE')
                <x-ui.button type="submit" variant="ghost" block>Hapus dari wishlist</x-ui.button>
            </form>
        @else
            <form method="POST" action="{{ route('wishlist.store') }}">
                @csrf
                <input type="hidden" name="game_id" value="{{ $game->game_id }}">
                <x-ui.button type="submit" variant="ghost" block>Tambah ke wishlist</x-ui.button>
            </form>
        @endif
    </div>
</x-ui.panel>
