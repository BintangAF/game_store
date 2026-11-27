{{--
  Isi tooltip saat kursor di atas kartu game (desktop). Taruh di dalam kartu yang punya atribut data-game-tip.
  JS: resources/js/modules/game-tip.js membaca <template> ini dan menampilkannya di sebelah kartu.
--}}
@props(['game'])
@php
    $average = $game->reviews_avg_star ?? null;
    $count = $game->reviews_count ?? 0;
    $verdict = match (true) {
        $count === 0 => 'Belum ada ulasan',
        $average >= 4.5 => 'Sangat Positif',
        $average >= 3.5 => 'Positif',
        $average >= 2.5 => 'Beragam',
        default => 'Negatif',
    };
@endphp
<template data-game-tip-content>
    <h4 class="text-fg font-extrabold">{{ $game->game_title }}</h4>
    <p class="text-xs text-soft">Dirilis: {{ \Illuminate\Support\Carbon::parse($game->release_date)->format('d/m/Y') }}</p>
    <p class="mt-2 line-clamp-5 text-sm text-muted">{{ $game->game_desc ?? '' }}</p>
    <div class="mt-3 rounded-sm border border-line bg-fg/5 p-2.5 text-sm">
        <p class="text-xs text-soft">Ulasan Umum Pengguna</p>
        <p><span class="font-bold text-accent-2">{{ $verdict }}</span> @if ($count > 0)<span class="text-soft">({{ $count }} ulasan)</span>@endif</p>
    </div>
    <p class="mt-3 text-xs text-soft">Tag pengguna:</p>
    <div class="mt-1 flex flex-wrap gap-1.5">
        @foreach (($game->categories ?? collect())->take(2) as $category)
            <x-ui.chip>{{ $category->category_name }}</x-ui.chip>
        @endforeach
        @foreach (($game->tags ?? collect())->take(4) as $tag)
            <x-ui.chip tone="tag">{{ $tag->tag_name }}</x-ui.chip>
        @endforeach
    </div>
</template>
