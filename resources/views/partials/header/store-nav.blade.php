{{-- Baris toko: Telusuri, Rekomendasi, Kategori, pencarian, wishlist, masuk/daftar, keranjang. --}}
<div class="border-t border-line">
    <div class="mx-auto flex max-w-[1240px] items-center gap-4 px-5 py-2">
        <nav class="hidden items-center gap-1 md:flex">
            <x-nav.dropdown label="Telusuri" :href="route('search')">
                <a href="{{ route('search') }}">Semua game</a>
                <a href="{{ route('search', ['sort' => 'newest']) }}">Rilisan terbaru</a>
                <a href="{{ route('search', ['sort' => 'bestseller']) }}">Terlaris</a>
            </x-nav.dropdown>
            <x-nav.dropdown label="Rekomendasi" :href="route('home')">
                <a href="{{ route('home') }}">Untukmu</a>
                <a href="{{ route('search', ['sort' => 'popular']) }}">Populer</a>
            </x-nav.dropdown>
            <x-nav.dropdown label="Kategori" :href="route('search')" wide>
                @foreach ($navCategories ?? [] as $category)
                    <a href="{{ route('search', ['category' => $category->category_id]) }}">{{ $category->category_name }}</a>
                @endforeach
            </x-nav.dropdown>
        </nav>

        <div class="flex flex-1 items-center gap-2 md:justify-end">
            @include('partials.header.search-form')
            <div class="hidden items-center gap-2 md:flex">
                <x-nav.link :href="route('wishlist')" :active="request()->routeIs('wishlist')">Wishlist</x-nav.link>
                @include('partials.header.auth-links')
                @include('partials.header.cart-link')
            </div>
        </div>
    </div>
</div>
