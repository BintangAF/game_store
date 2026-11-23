{{-- Data: $library (game dari order paid). --}}
<x-ui.section-title eyebrow="Koleksi" title="Pustaka game" :href="route('collection')" />
<x-ui.horizontal-row cols="lg:grid-cols-4">
    @foreach ($library as $game)
        <x-game.capsule :game="$game" />
    @endforeach
</x-ui.horizontal-row>
