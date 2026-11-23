{{-- Harga: normal, diskon, atau gratis. Memakai $game->game_price dan $game->discount_percent (boleh kosong). --}}
@props(['game'])
@php
    $price = (float) $game->game_price;
    $discount = $game->discount_percent ?? null;
    $final = $discount ? $price * (100 - $discount) / 100 : $price;
    $format = fn ($value) => 'Rp '.number_format($value, 0, ',', '.');
@endphp
<div {{ $attributes->merge(['class' => 'flex flex-wrap items-center gap-2']) }}>
    @if ($price == 0)
        <span class="text-[1.08rem] font-black">Gratis</span>
    @else
        @if ($discount)
            <x-ui.badge>-{{ $discount }}%</x-ui.badge>
            <s class="text-xs text-soft">{{ $format($price) }}</s>
        @endif
        <span class="text-[1.08rem] font-black">{{ $format($final) }}</span>
    @endif
</div>
