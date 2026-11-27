{{-- Tautan menu berbentuk pil. <x-nav.link :href="route('collection')" :active="request()->routeIs('collection')">Koleksi</x-nav.link> --}}
@props(['href', 'active' => false])
<a href="{{ $href }}" @class([
    'inline-flex items-center gap-1.5 rounded-full px-3.5 py-2 text-sm font-semibold transition-colors',
    'bg-accent-2 font-bold text-white' => $active,
    'text-muted hover:bg-fg/8 hover:text-fg' => ! $active,
])>{{ $slot }}</a>
