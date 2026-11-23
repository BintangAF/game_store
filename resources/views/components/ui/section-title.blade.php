{{-- <x-ui.section-title title="..." eyebrow="..." subtitle="..." href="..." /> --}}
@props(['title', 'eyebrow' => null, 'subtitle' => null, 'href' => null, 'linkText' => 'Lihat semua'])
<div class="mb-4 mt-10 flex flex-wrap items-end justify-between gap-3">
    <div>
        @if ($eyebrow)
            <p class="text-[0.72rem] font-extrabold uppercase tracking-[2px] text-accent-2">{{ $eyebrow }}</p>
        @endif
        <h2 class="text-[1.4rem] font-black tracking-tight">{{ $title }}</h2>
        @if ($subtitle)
            <p class="mt-0.5 text-sm text-soft">{{ $subtitle }}</p>
        @endif
    </div>
    @if ($href)
        <x-ui.button :href="$href" variant="outline" size="sm">{{ $linkText }}</x-ui.button>
    @endif
</div>
