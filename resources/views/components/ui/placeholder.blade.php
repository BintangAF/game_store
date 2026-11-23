{{-- Placeholder gambar netral. <x-ui.placeholder :hue="210" label="Game 1" class="h-40" /> --}}
@props(['hue' => 220, 'label' => null])
<div {{ $attributes->merge(['class' => 'ph flex items-end p-2 text-sm font-semibold']) }} style="--ph-h: {{ $hue }}">{{ $label }}</div>
