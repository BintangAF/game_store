{{-- Ringkasan rating: rata-rata, bintang, jumlah ulasan, dan sebaran 5 sampai 1 bintang. --}}
@props(['average' => 0, 'count' => 0, 'breakdown' => []])
@php
    $average = (float) $average;
    $steps = ['w-0', 'w-[10%]', 'w-[20%]', 'w-[30%]', 'w-[40%]', 'w-[50%]', 'w-[60%]', 'w-[70%]', 'w-[80%]', 'w-[90%]', 'w-full'];
    $starFill = $steps[(int) round($average / 5 * 10)]; // pembulatan ke setengah bintang
    $total = max(1, (int) $count);
@endphp
<div class="grid items-center gap-5 sm:grid-cols-[11rem_1fr]">
    <div class="text-center sm:text-left">
        <p class="text-5xl font-black leading-none">{{ number_format($average, 1, ',', '.') }}</p>
        <div class="relative mt-2 inline-block text-xl leading-none" aria-hidden="true">
            <span class="text-fg/25">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            <span class="absolute inset-y-0 left-0 overflow-hidden whitespace-nowrap text-star {{ $starFill }}">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
        </div>
        <p class="mt-1 text-sm text-soft">{{ $count > 0 ? $count.' ulasan' : 'Belum ada ulasan' }}</p>
    </div>

    <div class="space-y-1.5">
        @foreach ([5, 4, 3, 2, 1] as $star)
            @php $n = (int) ($breakdown[$star] ?? 0); @endphp
            <div class="flex items-center gap-3 text-xs text-soft">
                <span class="w-8 shrink-0">{{ $star }} &#9733;</span>
                <div class="h-2 flex-1 overflow-hidden rounded-full bg-fg/10">
                    <div class="h-full rounded-full bg-star {{ $steps[(int) round($n / $total * 10)] }}"></div>
                </div>
                <span class="w-8 shrink-0 text-right">{{ $n }}</span>
            </div>
        @endforeach
    </div>
</div>
