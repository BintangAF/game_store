{{-- Galeri. Data: $game->images (image_path, sort_order). JS: gallery. --}}
@php
    $slides = ($game->images ?? collect())->count() ? $game->images->values() : collect([null]);
@endphp
<div data-js="gallery">
    @foreach ($slides as $i => $image)
        <div data-gallery-slide="{{ $i }}" class="aspect-video overflow-hidden rounded-md border border-line bg-deep shadow-elev {{ $i === 0 ? '' : 'hidden' }}">
            @if ($image && $image->image_path)
                <img src="{{ Storage::url($image->image_path) }}" alt="{{ $game->game_title }}" class="h-full w-full object-cover">
            @else
                <x-ui.placeholder :hue="($game->game_id * 47 + $i * 30) % 360" :label="$game->game_title" class="h-full w-full" />
            @endif
        </div>
    @endforeach

    @if ($slides->count() > 1)
        <div class="mt-2.5 grid grid-cols-4 gap-2">
            @foreach ($slides as $i => $image)
                <button type="button" data-gallery-thumb="{{ $i }}" class="aspect-video overflow-hidden rounded-lg border-2 border-transparent opacity-70 transition hover:opacity-100" aria-label="Gambar {{ $i + 1 }}">
                    @if ($image && $image->image_path)
                        <img src="{{ Storage::url($image->image_path) }}" alt="" class="h-full w-full object-cover">
                    @else
                        <x-ui.placeholder :hue="($game->game_id * 47 + $i * 30) % 360" class="h-full w-full" />
                    @endif
                </button>
            @endforeach
        </div>
    @endif
</div>
