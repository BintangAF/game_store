{{-- Menu samping mobile. Dibuka oleh checkbox #drawer-toggle (tanpa JS). --}}
<label for="drawer-toggle" class="fixed inset-0 z-40 hidden bg-deep/70 backdrop-blur-sm peer-checked:block md:hidden" aria-hidden="true"></label>

<aside class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full overflow-y-auto border-r border-line-teal bg-deep/95 backdrop-blur-lg transition-transform peer-checked:translate-x-0 md:hidden">
    <div class="flex items-center justify-between border-b border-line px-5 py-4">
        <x-ui.brand />
        <label for="drawer-toggle" class="cursor-pointer text-2xl" aria-label="Tutup menu">&times;</label>
    </div>

    <nav class="flex flex-col gap-0.5 p-2 text-muted [&>a]:rounded-lg [&>a]:px-3 [&>a]:py-3 [&>a]:font-semibold [&>a:hover]:bg-accent-2/15 [&>a:hover]:text-fg">
        @guest
            <a href="{{ route('login') }}">Masuk</a>
            <a href="{{ route('register') }}">Daftar</a>
        @endguest
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('collection') }}">Koleksi</a>
        <a href="{{ route('cart') }}">Keranjang</a>
        <a href="{{ route('wishlist') }}">Wishlist</a>
        <a href="{{ route('about') }}">Tentang</a>
        <a href="{{ route('profile') }}">Profil</a>
        <p class="px-3 pb-1 pt-4 text-xs font-extrabold uppercase tracking-[2px] text-accent-2">Kategori</p>
        @foreach ($navCategories ?? [] as $category)
            <a href="{{ route('search', ['category' => $category->category_id]) }}">{{ $category->category_name }}</a>
        @endforeach
    </nav>
</aside>
