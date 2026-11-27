{{-- Logo gambar saja (tanpa teks). <x-ui.brand /> --}}
<a href="{{ route('home') }}" aria-label="Beranda" {{ $attributes->merge(['class' => 'inline-flex items-center']) }}>
    <img src="{{ asset('images/brand/logo.png') }}" alt="Logo toko game" class="h-10 w-auto select-none" draggable="false">
</a>
