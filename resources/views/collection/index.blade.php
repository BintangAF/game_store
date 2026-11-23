{{-- Koleksi. Data: $library (game dari order berstatus paid). --}}
@extends('layouts.app')
@section('title', 'Koleksi')
@section('content')
    <h1 class="mb-1 text-2xl font-black">Koleksi saya</h1>
    <p class="mb-4 text-sm text-muted">Game yang sudah kamu beli.</p>

    @if (count($library))
        <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
            @foreach ($library as $game)
                <x-game.card :game="$game" />
            @endforeach
        </div>
    @else
        <x-ui.empty-state title="Koleksi masih kosong" message="Game yang sudah dibayar akan muncul di sini." :href="route('search')" action="Cari game" />
    @endif
@endsection
