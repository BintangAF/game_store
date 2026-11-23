{{-- <x-ui.badge tone="accent|sage|muted">-30%</x-ui.badge> --}}
@props(['tone' => 'accent'])
@php
    $tones = [
        'accent' => 'border-accent/40 bg-accent/22 text-accent-soft',
        'sage' => 'border-line-teal bg-accent-2/18 text-accent-2',
        'muted' => 'border-line bg-fg/7 text-muted',
    ];
@endphp
<span {{ $attributes->merge(['class' => 'inline-flex w-fit items-center rounded-full border px-2.5 py-0.5 text-[0.7rem] font-extrabold uppercase tracking-wider '.$tones[$tone]]) }}>{{ $slot }}</span>
