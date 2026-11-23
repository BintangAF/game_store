{{-- Baris atas: tombol menu (mobile), logo, menu utama. Rata kiri. --}}
<div class="flex min-h-16 items-center gap-6 px-5 py-2">
    <label for="drawer-toggle" class="flex cursor-pointer items-center text-2xl md:hidden" aria-label="Buka menu">&#9776;</label>

    <x-ui.brand />

    <nav class="hidden items-center gap-1 md:flex">
        <x-nav.dropdown label="Home" :href="route('home')" :active="request()->routeIs('home')">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('search', ['sort' => 'newest']) }}">Rilisan terbaru</a>
            <a href="{{ route('search', ['sort' => 'bestseller']) }}">Terlaris</a>
        </x-nav.dropdown>
        <x-nav.link :href="route('collection')" :active="request()->routeIs('collection')">Koleksi</x-nav.link>
        <x-nav.link :href="route('about')" :active="request()->routeIs('about')">Tentang</x-nav.link>
        <x-nav.link :href="route('profile')" :active="request()->routeIs('profile*')">Profil</x-nav.link>
    </nav>

    <div class="ml-auto flex items-center md:hidden">
        @include('partials.header.cart-link')
    </div>
</div>
