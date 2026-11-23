{{-- Wishlist. Data: $wishlist (game dari tabel wishlists). --}}
@extends('layouts.app')
@section('title', 'Wishlist')
@section('content')
    <h1 class="mb-1 text-2xl font-black">Wishlist</h1>
    <p class="mb-4 text-sm text-muted">Game yang kamu simpan untuk dibeli nanti.</p>

    @if (count($wishlist))
        <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
            @foreach ($wishlist as $game)
                <div>
                    <x-game.card :game="$game" :wish="false" />
                    <form method="POST" action="{{ route('wishlist.destroy', $game->game_id) }}" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <x-ui.button type="submit" variant="danger" size="sm" block>Hapus dari wishlist</x-ui.button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <x-ui.empty-state title="Wishlist masih kosong" message="Tekan tombol wishlist di halaman detail game." :href="route('search')" action="Cari game" />
    @endif
@endsection
