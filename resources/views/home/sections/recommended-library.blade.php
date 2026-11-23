{{-- Rekomendasi dari game yang dimiliki. Data: $recommendedByLibrary (5 game). --}}
@if (count($recommendedByLibrary ?? []))
<x-ui.section-title eyebrow="Rekomendasi" title="Direkomendasikan untukmu" subtitle="Berdasarkan game yang sudah kamu miliki" :href="route('search')" />
<x-ui.horizontal-row cols="lg:grid-cols-5">
    @foreach ($recommendedByLibrary as $game)
        <x-game.capsule :game="$game" />
    @endforeach
</x-ui.horizontal-row>
@endif
