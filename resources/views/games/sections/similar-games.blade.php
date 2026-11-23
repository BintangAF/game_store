{{-- Data: $similarGames (4 game). --}}
<x-ui.section-title eyebrow="Serupa" title="Game serupa" />
<x-ui.horizontal-row cols="lg:grid-cols-4">
    @foreach ($similarGames as $game)
        <x-game.card :game="$game" />
    @endforeach
</x-ui.horizontal-row>
