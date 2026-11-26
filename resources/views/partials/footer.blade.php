<footer class="mt-8 border-t border-line bg-deep/90 text-sm text-soft">
    <div class="mx-auto grid max-w-[1240px] gap-8 px-5 py-8 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <x-ui.brand />
            <p class="mt-3">&copy; {{ date('Y') }} VIRRATE. Proyek akhir mata kuliah PBP.</p>
        </div>
        <div>
            <h3 class="mb-2 text-xs font-extrabold uppercase tracking-[2px] text-accent-2">Toko</h3>
            <ul class="space-y-1">
                <li><a href="{{ route('home') }}" class="hover:text-fg">Beranda</a></li>
                <li><a href="{{ route('search') }}" class="hover:text-fg">Semua game</a></li>
                <li><a href="{{ route('cart') }}" class="hover:text-fg">Keranjang</a></li>
            </ul>
        </div>
        <div>
            <h3 class="mb-2 text-xs font-extrabold uppercase tracking-[2px] text-accent-2">Akun</h3>
            <ul class="space-y-1">
                <li><a href="{{ route('login') }}" class="hover:text-fg">Masuk</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-fg">Daftar</a></li>
                <li><a href="{{ route('profile') }}" class="hover:text-fg">Profil</a></li>
            </ul>
        </div>
        <div>
            <h3 class="mb-2 text-xs font-extrabold uppercase tracking-[2px] text-accent-2">Info</h3>
            <ul class="space-y-1">
                <li><a href="{{ route('about') }}" class="hover:text-fg">Tentang</a></li>
            </ul>
        </div>
    </div>
</footer>
