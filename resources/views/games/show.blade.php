{{-- Detail game. Data: $game (+relasi), $reviews, $canReview, $owned, $inCart, $similarGames. --}}
@extends('layouts.app')
@section('title', $game->game_title)
@section('content')
    <h1 class="mb-4 text-2xl font-black md:text-3xl">{{ $game->game_title }}</h1>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            @include('games.sections.gallery')
            @include('games.sections.about-game')
            @include('games.sections.system-requirements')
            @include('games.sections.reviews')
        </div>
        <aside>
            @include('games.sections.buy-box')
        </aside>
    </div>

    @include('games.sections.similar-games')
@endsection
