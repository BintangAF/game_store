{{-- Data: $underPrice (5 game dengan harga <= 90000). --}}
<x-ui.section-title eyebrow="Hemat" title="Di bawah Rp 90.000" :href="route('search', ['max_price' => 90000])" />
<x-ui.horizontal-row cols="lg:grid-cols-5">
    @foreach ($underPrice as $game)
        <x-game.capsule :game="$game" />
    @endforeach
</x-ui.horizontal-row>
