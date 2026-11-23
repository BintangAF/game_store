{{-- Baris kartu: geser samping di mobile, grid di desktop. <x-ui.horizontal-row cols="lg:grid-cols-4"> --}}
@props(['cols' => 'lg:grid-cols-5'])
<div {{ $attributes->merge(['class' => 'flex snap-x gap-3 overflow-x-auto pb-2 md:grid md:grid-cols-3 md:overflow-visible [&>*]:w-64 [&>*]:shrink-0 [&>*]:snap-start md:[&>*]:w-auto '.$cols]) }}>
    {{ $slot }}
</div>
