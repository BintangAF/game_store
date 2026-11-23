{{-- <x-ui.chip href="..." tone="teal|tag|os">Tag</x-ui.chip> --}}
@props(['href' => null, 'tone' => 'teal'])
@php
    $tones = [
        'teal' => 'border-accent-2/30 bg-accent-2/20 text-accent-2',
        'tag' => 'border-line bg-fg/7 text-muted',
        'os' => 'border-accent/30 bg-accent/14 text-accent-soft',
    ];
    $classes = 'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-bold '.$tones[$tone];
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes.' hover:brightness-125']) }}>{{ $slot }}</a>
@else
    <span {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</span>
@endif
