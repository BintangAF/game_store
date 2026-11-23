{{-- Dropdown navbar. Terbuka saat hover atau fokus (tanpa JS). <x-nav.dropdown label="Home" :href="..." wide> --}}
@props(['label', 'href' => '#', 'wide' => false, 'active' => false])
<div class="group relative flex items-center">
    <a href="{{ $href }}" @class([
        'inline-flex items-center gap-1.5 rounded-full px-3.5 py-2 text-sm font-semibold transition-colors',
        'bg-accent-2 font-bold text-deep' => $active,
        'text-muted hover:bg-fg/8 hover:text-fg' => ! $active,
    ])>{{ $label }} <span aria-hidden="true" class="text-[10px]">&#9662;</span></a>

    <div class="absolute left-0 top-full z-40 hidden pt-2 group-focus-within:block group-hover:block">
        <div @class([
            'min-w-52 rounded-xl border border-line-teal bg-deep/95 p-2 shadow-elev backdrop-blur-lg',
            '[&>a]:block [&>a]:rounded-lg [&>a]:px-3 [&>a]:py-2 [&>a]:text-sm [&>a]:text-muted [&>a:hover]:bg-accent-2/15 [&>a:hover]:text-fg',
            'grid min-w-80 grid-cols-2' => $wide,
        ])>
            {{ $slot }}
        </div>
    </div>
</div>
