{{-- <x-ui.panel class="...">isi</x-ui.panel> --}}
<div {{ $attributes->merge(['class' => 'rounded-md border border-line bg-panel p-5 shadow-elev backdrop-blur-md']) }}>{{ $slot }}</div>
