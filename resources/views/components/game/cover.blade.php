{{-- Cover game: gambar asli, atau placeholder bila kosong. <x-game.cover :game="$game" class="aspect-video w-full" /> --}}
@props(['game', 'class' => ''])
@if ($game->cover_image_path ?? null)
    <img src="{{ Storage::url($game->cover_image_path) }}" alt="{{ $game->game_title }}" loading="lazy" {{ $attributes->merge(['class' => $class.' object-cover']) }}>
@else
    <x-ui.placeholder :hue="($game->game_id * 47) % 360" :label="$game->game_title" :class="$class" />
@endif
