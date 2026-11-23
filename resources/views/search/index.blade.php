{{-- Hasil pencarian. Data: $games (paginate), $query, $filters, $categories, $operatingSystems. --}}
@extends('layouts.app')
@section('title', 'Pencarian')
@section('content')
    <h1 class="mb-4 text-2xl font-black">
        @if ($query ?? null)
            Hasil pencarian untuk “{{ $query }}”
        @else
            Semua game
        @endif
    </h1>

    <div class="grid gap-6 lg:grid-cols-4">
        <aside>
            @include('search._filters')
        </aside>

        <div class="lg:col-span-3">
            @if (count($games))
                <div class="grid grid-cols-2 gap-3 md:grid-cols-3">
                    @foreach ($games as $game)
                        <x-game.card :game="$game" />
                    @endforeach
                </div>

                @if (method_exists($games, 'hasPages') && $games->hasPages())
                    {{ $games->links('partials.pagination') }}
                @endif
            @else
                <x-ui.empty-state title="Game tidak ditemukan" message="Coba kata kunci atau filter lain." :href="route('home')" />
            @endif
        </div>
    </div>
@endsection
