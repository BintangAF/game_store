{{-- Deskripsi. Data: $game->game_desc, categories, tags. --}}
<x-ui.panel>
    <h2 class="mb-2 text-lg font-black">Tentang game ini</h2>
    <p class="text-sm leading-relaxed text-muted">{{ $game->game_desc }}</p>
    <div class="mt-4 flex flex-wrap gap-2">
        @foreach (($game->categories ?? collect()) as $category)
            <x-ui.chip :href="route('search', ['category' => $category->category_id])">{{ $category->category_name }}</x-ui.chip>
        @endforeach
        @foreach (($game->tags ?? collect()) as $tag)
            <x-ui.chip tone="tag">{{ $tag->tag_name }}</x-ui.chip>
        @endforeach
    </div>
</x-ui.panel>
