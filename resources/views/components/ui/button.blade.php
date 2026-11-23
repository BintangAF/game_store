{{-- <x-ui.button href="..." variant="primary|teal|outline|ghost|danger" size="sm|md|lg" block>Teks</x-ui.button> --}}
@props(['href' => null, 'variant' => 'primary', 'size' => 'md', 'block' => false])
@php
    $sizes = ['sm' => 'px-3 py-1.5 text-xs', 'md' => 'px-4.5 py-2.5 text-sm', 'lg' => 'px-6 py-3 text-base'];
    $variants = [
        'primary' => 'bg-linear-to-br from-accent to-[#d4373c] text-fg shadow-glow-red hover:-translate-y-0.5 hover:brightness-110',
        'teal' => 'bg-accent-2 text-deep shadow-glow-teal hover:-translate-y-0.5 hover:brightness-105',
        'outline' => 'border-line-teal bg-accent-2/8 text-fg hover:bg-accent-2/20',
        'ghost' => 'bg-fg/8 text-fg hover:bg-fg/16',
        'danger' => 'border-accent/40 bg-accent/15 text-accent-soft hover:bg-accent hover:text-fg',
    ];
    $classes = 'inline-flex items-center justify-center gap-2 rounded-sm border border-transparent font-bold transition '
        .$sizes[$size].' '.$variants[$variant].($block ? ' w-full' : '');
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>{{ $slot }}</button>
@endif
