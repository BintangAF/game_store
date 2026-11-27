{{-- Baris atas: tombol menu (mobile), logo, menu utama. Rata kiri. --}}
<div class="mx-auto flex max-w-[1240px] items-center gap-4 px-5 py-2">
    <label for="drawer-toggle" class="flex cursor-pointer items-center text-2xl md:hidden" aria-label="Buka menu">&#9776;</label>

    <x-ui.brand class="[&>img]:h-20" />

    <nav class="hidden items-center gap-3 md:flex">
        <x-nav.dropdown label="Home" :href="route('home')" :active="request()->routeIs('home')">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('search', ['sort' => 'newest']) }}">Rilisan terbaru</a>
            <a href="{{ route('search', ['sort' => 'bestseller']) }}">Terlaris</a>
        </x-nav.dropdown>
        <x-nav.link :href="route('collection')" :active="request()->routeIs('collection')">Koleksi</x-nav.link>
        <x-nav.link :href="route('about')" :active="request()->routeIs('about')">Tentang</x-nav.link>
        <x-nav.link :href="route('profile')" :active="request()->routeIs('profile*')">Profil</x-nav.link>
    </nav>

    {{-- Pemberitahuan bergeser: mengisi ruang kosong di kanan menu (desktop). Hilang sendiri bila kosong. --}}
    @if (! empty($headerNotices))
        <div class="hidden min-w-0 flex-1 justify-end md:flex">
            <x-ui.ticker :items="$headerNotices" class="w-full max-w-md" />
        </div>
    @endif

    <div class="ml-auto flex items-center md:hidden">
        @include('partials.header.cart-link')
    </div>
</div>
