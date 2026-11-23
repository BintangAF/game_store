{{-- Data: $becauseOf (1 game dimiliki), $becauseOfGames (4 game dengan tag serupa). --}}
@if (($becauseOf ?? null) && count($becauseOfGames ?? []))
<x-ui.section-title eyebrow="Serupa" :title="'Karena kamu memiliki '.$becauseOf->game_title" subtitle="Game dengan tag serupa" />
<x-ui.horizontal-row cols="lg:grid-cols-4">
    @foreach ($becauseOfGames as $game)
        <x-game.tag-card :game="$game" />
    @endforeach
</x-ui.horizontal-row>
@endif
