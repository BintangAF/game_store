{{-- Data: $newReleases (4 game). --}}
<x-ui.section-title eyebrow="Baru" title="Rilisan terbaru" :href="route('search', ['sort' => 'newest'])" />
<x-ui.horizontal-row cols="lg:grid-cols-4">
    @foreach ($newReleases as $game)
        <x-game.card :game="$game" />
    @endforeach
</x-ui.horizontal-row>
