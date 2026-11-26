# 07. Teknologi, komponen, peta file, dan cara backend menyambung

## 1. Teknologi yang dipakai

| Lapisan | Teknologi | Dipakai untuk |
|---|---|---|
| Bahasa server | PHP 8.3 ke atas | Menjalankan Laravel |
| Framework | **Laravel 13** | Route, controller, database, login, validasi |
| Template halaman | **Blade** | Menulis HTML yang berisi data dari controller: `{{ $game->game_title }}`, `@foreach`, `@if`, dan komponen `<x-...>` |
| Gaya | **Tailwind CSS v4** | Kelas utilitas langsung di HTML (`rounded-md`, `bg-panel`). Pengaturan ada di CSS (`theme.css`), tanpa `tailwind.config.js` |
| Build aset | **Vite 8** dengan `laravel-vite-plugin` dan `@tailwindcss/vite` | Menggabungkan CSS dan JS. `npm run dev` untuk pengembangan, `npm run build` untuk server |
| Perilaku halaman | **JavaScript biasa** (ES module) | Carousel, tab, galeri, tooltip, baris geser. Tanpa React, Vue, atau jQuery |
| Panel admin | Filament 5 | Milik backend. Filament memakai Livewire di dalamnya, halaman toko tidak |
| Database | SQLite sementara, rencananya MySQL atau MariaDB | Milik backend |
| Alat | Composer (paket PHP), npm (paket JS), Git | |

Bagian frontend (folder `resources/`, `routes/preview*.php`, `public/images/`) hanya memakai Blade, Tailwind, Vite, dan JavaScript biasa.

## 2. Komponen: fungsinya

Komponen adalah potongan tampilan yang bisa dipakai berulang, ditulis sekali di `resources/views/components/` dan dipanggil dengan `<x-nama />`. Cara kerjanya mirip fungsi: ada masukan (props) dan keluaran (HTML).

Contoh. File `components/game/card.blade.php` dipanggil seperti ini:

```blade
@foreach ($games as $game)
    <x-game.card :game="$game" />
@endforeach
```

Nama pemanggilan mengikuti folder: `components/game/card.blade.php` menjadi `<x-game.card>`.

Manfaatnya:
- **Ubah sekali, semua halaman ikut.** Bentuk kartu game ada di satu file, tetapi dipakai di Home, pencarian, koleksi, wishlist, dan game serupa.
- **Tampilan seragam.** Tombol, kartu, dan kotak selalu sama karena semua halaman memakai komponen yang sama.
- **Halaman jadi pendek.** Halaman hanya menyusun komponen, tanpa menulis ulang markup.

Perbedaan empat jenis potongan di folder `views/`:

| Jenis | Folder | Sifat | Dipanggil dengan |
|---|---|---|---|
| Layout | `layouts/` | Kerangka seluruh halaman (head, header, footer) | `@extends('layouts.app')` |
| Partial | `partials/` | Potongan tetap yang tidak berubah isinya (header, footer) | `@include('partials.footer')` |
| Section | `home/sections/`, `games/sections/`, `profile/sections/` | Potongan satu halaman, dipisah agar file tidak panjang | `@include('home.sections.tag-duo')` |
| Komponen | `components/` | Dipakai berulang di banyak tempat, punya props | `<x-game.card :game="$game" />` |

## 3. Peta file

Zip frontend berisi folder `resources/`, `routes/`, `public/images/`, dan `docs/`. Folder lain milik Laravel dan backend: `app/` (controller dan model), `database/`, `config/`, `routes/web.php`.

### routes/

| File | Fungsi |
|---|---|
| `preview.php` | Route sementara supaya semua halaman bisa dibuka dengan data contoh. Dihapus bertahap saat controller backend jadi. |
| `preview-data.php` | Pembuat data contoh (`pv_game()`, `pv_games()`, `pv_reviews()`, dan lainnya). Bentuk objeknya mengikuti ERD. Dihapus bersama `preview.php`. |

### public/images/

Tiap folder berisi file `.gitkeep` kosong supaya folder ikut tersimpan di Git.

| Folder | Fungsi |
|---|---|
| `brand/` | Logo dan ikon merek, bila nanti memakai gambar. |
| `placeholder/` | Gambar pengganti, bila dibutuhkan. |
| `banners/` | Banner promo. |
| `icons/` | Ikon. |
| `payment/` | Logo metode pembayaran (dipakai halaman checkout). |

### resources/css/

| File | Fungsi |
|---|---|
| `app.css` | Pintu masuk CSS. Hanya berisi `@import` ke file lain dan sumber bawaan Laravel. |
| `theme.css` | Semua warna, sudut, bayangan, dan font. Ganti di sini, seluruh situs ikut berubah. |
| `base.css` | Gaya dasar: latar halaman (cahaya dan garis kisi) dan outline fokus. |
| `components/placeholder.css` | Gaya `.ph`, warna netral untuk gambar pengganti. Tidak ikut palet. |

### resources/js/

| File | Fungsi |
|---|---|
| `app.js` | Pintu masuk JS. Mendaftarkan semua modul. |
| `core/boot.js` | Pemasang modul. Mencari elemen ber-atribut `data-js="nama"` lalu menjalankan modul bernama itu. |
| `modules/carousel.js` | Banner Home: loop tanpa ujung, geser otomatis, preview slide samping, titik, swipe. |
| `modules/scroller.js` | Baris yang bisa digeser (kotak kategori): tombol, titik halaman, swipe. |
| `modules/ticker.js` | Pemberitahuan di header: item naik bergantian, berputar tanpa ujung, berhenti saat kursor di atasnya. |
| `modules/tabs.js` | Tab daftar game di Home. |
| `modules/gallery.js` | Ganti gambar utama saat thumbnail diklik di halaman detail. |
| `modules/game-tip.js` | Tooltip detail game saat kursor di atas kartu. |

### resources/views/layouts/

| File | Fungsi |
|---|---|
| `app.blade.php` | Kerangka utama toko: header dua baris, menu samping mobile, konten, footer. |
| `auth.blade.php` | Kerangka login dan daftar: kotak di tengah, tanpa navbar. |
| `checkout.blade.php` | Kerangka checkout: header atas, konten lebih sempit. |

### resources/views/partials/

| File | Fungsi |
|---|---|
| `head.blade.php` | Isi `<head>`: judul, viewport, pemuatan CSS dan JS lewat `@vite`. |
| `footer.blade.php` | Footer dengan empat kolom. |
| `flash.blade.php` | Pesan sukses dan daftar error validasi. |
| `pagination.blade.php` | Tampilan nomor halaman bertema (dipakai pencarian dan ulasan). |
| `header/top.blade.php` | Baris atas header: tombol menu mobile, logo, menu Home, Koleksi, Tentang, Profil. |
| `header/store-nav.blade.php` | Baris toko: Telusuri, Rekomendasi, Kategori, pencarian, wishlist, masuk, keranjang. |
| `header/search-form.blade.php` | Kolom pencarian. |
| `header/auth-links.blade.php` | Tombol Masuk dan Daftar, atau nama pengguna dan Keluar saat sudah login. |
| `header/cart-link.blade.php` | Tombol keranjang dengan jumlah item. |
| `header/mobile-drawer.blade.php` | Menu samping untuk HP. |

### resources/views/components/

| File | Fungsi |
|---|---|
| `ui/brand` | Logo LINTAR.STORE. |
| `ui/button` | Semua tombol dan tautan tombol (varian primary, teal, outline, ghost, danger). |
| `ui/panel` | Kotak kaca untuk konten. |
| `ui/section-title` | Judul section dengan label kecil dan tombol "Lihat semua". |
| `ui/badge` | Lencana kecil, misalnya "-30%". |
| `ui/chip` | Label tag, kategori, atau sistem operasi. |
| `ui/tile` | Kotak kategori. |
| `ui/placeholder` | Gambar pengganti netral. |
| `ui/horizontal-row` | Baris kartu: geser samping di HP, grid di desktop. |
| `ui/scroller` | Baris yang bisa digeser dengan tombol dan titik halaman. |
| `ui/ticker` | Pemberitahuan bergeser di header (pembeli terbanyak, game segera rilis). |
| `ui/carousel` | Pembungkus carousel Home. |
| `ui/empty-state` | Tampilan kosong (keranjang kosong dan sejenisnya). |
| `ui/todo` | Penanda bagian yang belum diisi (tampil hanya di mode lokal). |
| `game/cover` | Cover game, atau placeholder bila gambar kosong. |
| `game/price` | Harga, diskon, atau "Gratis". |
| `game/rating` | Bintang rata-rata dan jumlah ulasan. |
| `game/card` | Kartu game lengkap: cover, rating, tombol wishlist, chip, harga. |
| `game/capsule` | Kapsul ringkas: cover, judul, harga. |
| `game/tag-card` | Kartu dengan deretan tag. |
| `game/list-row` | Baris daftar dengan cover kecil. |
| `game/tooltip` | Isi tooltip saat kursor di atas kartu game. |
| `form/input` | Input teks dengan label dan pesan error. |
| `form/select` | Dropdown pilihan. |
| `form/checkbox` | Checkbox. |
| `form/field-error` | Pesan error satu field. |
| `nav/link` | Tautan menu berbentuk pil. |
| `nav/dropdown` | Dropdown menu (terbuka saat hover, tanpa JS). |
| `cart/item` | Satu baris item di keranjang. |
| `cart/summary` | Ringkasan keranjang dan tombol checkout. |
| `review/summary` | Ringkasan rating: rata-rata, bintang, sebaran 5 sampai 1. |
| `review/item` | Satu ulasan. |
| `review/form` | Formulir ulasan. |
| `review/star-input` | Pilihan bintang 1 sampai 5. |
| `checkout/stepper` | Indikator langkah checkout (kerangka, milik Maul). |
| `checkout/payment-option` | Satu pilihan metode bayar (kerangka, milik Maul). |
| `checkout/order-summary` | Ringkasan pesanan (kerangka, milik Maul). |

### resources/views/ (halaman)

| File | Fungsi |
|---|---|
| `home/index.blade.php` | Halaman Home. Hanya menyusun section di bawah. |
| `home/sections/featured-carousel` | Banner berjalan. |
| `home/sections/browse-category` | Kotak kategori yang bisa digeser. |
| `home/sections/recommended-library` | Rekomendasi dari game yang dimiliki. |
| `home/sections/because-you-played` | "Karena kamu memiliki ..." dengan kartu bertag. |
| `home/sections/tag-duo` | Dua blok kategori, masing-masing 4 game. |
| `home/sections/top-new-releases` | Rilisan terbaru. |
| `home/sections/tabbed-list` | Daftar game dengan tab. |
| `home/sections/under-price` | Game di bawah Rp 90.000. |
| `games/show.blade.php` | Halaman detail game. Menyusun section di bawah. |
| `games/sections/gallery` | Galeri gambar. |
| `games/sections/buy-box` | Kotak beli: info, harga, tombol keranjang dan wishlist. |
| `games/sections/about-game` | Deskripsi, kategori, tag. |
| `games/sections/system-requirements` | Spesifikasi sistem dan sistem operasi. |
| `games/sections/reviews` | Rating, daftar ulasan, formulir untuk pembeli. |
| `games/sections/similar-games` | Game serupa. |
| `search/index.blade.php` | Hasil pencarian dengan paginasi. |
| `search/_filters.blade.php` | Formulir filter pencarian. |
| `auth/login.blade.php` | Formulir masuk. |
| `auth/register.blade.php` | Formulir daftar. |
| `collection/index.blade.php` | Koleksi game yang sudah dibeli. |
| `wishlist/index.blade.php` | Daftar wishlist. |
| `cart/index.blade.php` | Keranjang. |
| `checkout/payment.blade.php` | Checkout langkah 1, pilih metode bayar (kerangka, milik Maul). |
| `checkout/review.blade.php` | Checkout langkah 2, tinjau pesanan (kerangka, milik Maul). |
| `checkout/status.blade.php` | Checkout langkah 3, status pembayaran (kerangka, milik Maul). |
| `profile/show.blade.php` | Halaman profil. Menyusun section di bawah. |
| `profile/sections/header` | Kepala profil: avatar, nama, email. |
| `profile/sections/library` | Pustaka game. |
| `profile/sections/orders` | Riwayat transaksi. |
| `profile/edit.blade.php` | Formulir ubah profil. |
| `about/index.blade.php` | Halaman Tentang. |
| `errors/404.blade.php` | Halaman "tidak ditemukan". Dipakai Laravel otomatis. |

### docs/

| File | Isi |
|---|---|
| `01-SETUP.md` | Cara menyiapkan project di laptop. |
| `02-STRUCTURE.md` | Struktur folder dan tabel "mau ubah X, buka file Y". |
| `03-WORKFLOW.md` | Alur kerja, git, dan pemetaan dari HTML lama. |
| `04-DATA-CONTRACT.md` | Variabel, route, dan field form tiap halaman. Dokumen penghubung ke backend. |
| `05-PEMBAGIAN-TIM.md` | Pembagian tugas Bintang, Lintar, Neo, Maul. |
| `06-PANDUAN-STYLE.md` | Aturan gaya dan katalog komponen. |
| `07-PETA-FILE.md` | Dokumen ini. |
| `template-data-game.csv` | Template data game untuk Neo. |

## 4. Cara backend menyambungkan ke frontend

Prinsipnya: **file di `resources/views/` tidak diubah.** Backend hanya membuat route, controller, dan model, lalu mengirim variabel bernama sama dengan yang dibaca view. Nama variabel dan bentuknya ada di `04-DATA-CONTRACT.md`. Contoh data ada di `routes/preview.php` dan `routes/preview-data.php`.

Alurnya:

```
Browser -> routes/web.php -> Controller (ambil data dari database lewat Model)
        -> return view('games.show', [ variabel ... ])
        -> Blade + komponen menjadi HTML
```

### Langkah

1. **Migration dan model** mengikuti ERD. Bila nama kolom ERD dipertahankan (`game_id`), model perlu `protected $primaryKey = 'game_id';`.
2. **Pindahkan route** satu per satu dari `routes/preview.php` ke `routes/web.php`, dengan **nama route yang sama**, karena view memanggil `route('games.show', ...)`. Hapus route yang sudah pindah dari `preview.php`.
3. **Variabel global** (`$cartCount`, `$navCategories`) dibagikan lewat View Composer.
4. **Controller per halaman** mengirim variabel sesuai kontrak.
5. **Aksi** (login, keranjang, wishlist, ulasan, checkout) memakai nama route dan nama field di bagian 4 kontrak.
6. **Gambar:** jalankan `php artisan storage:link`. Komponen `game/cover` memakai `Storage::url($game->cover_image_path)`.
7. **Selesai:** setelah semua route pindah, hapus `preview.php`, `preview-data.php`, dan barisnya di `routes/web.php`.

### Contoh: model Game

```php
class Game extends Model
{
    protected $primaryKey = 'game_id';

    public function categories() { return $this->belongsToMany(Category::class, 'game_category', 'game_id', 'category_id'); }
    public function tags() { return $this->belongsToMany(Tag::class, 'game_tag', 'game_id', 'tag_id'); }
    public function operatingSystems() { return $this->belongsToMany(OperatingSystem::class, 'game_os', 'game_id', 'os_id'); }
    public function images() { return $this->hasMany(GameImage::class, 'game_id')->orderBy('sort_order'); }
    public function reviews() { return $this->hasMany(Review::class, 'game_id'); }
}
```

### Contoh: variabel global

```php
// app/Providers/AppServiceProvider.php, di dalam boot()
View::composer('partials.header.*', function ($view) {
    $view->with('cartCount', auth()->check() ? Cart::where('user_id', auth()->id())->count() : 0)
         ->with('navCategories', Category::orderBy('category_name')->get());
});
```

### Contoh: halaman Home

```php
public function index()
{
    $games = fn () => Game::with(['categories', 'tags'])->withAvg('reviews', 'star')->withCount('reviews');

    return view('home.index', [
        'featured' => $games()->latest('release_date')->take(5)->get(),
        'categories' => Category::all(),
        'newReleases' => $games()->latest('release_date')->take(4)->get(),
        'underPrice' => $games()->where('game_price', '<=', 90000)->take(5)->get(),
        // $recommendedByLibrary, $becauseOf, $becauseOfGames, $tagBlocks, $tabs: pola yang sama
    ]);
}
```

`withAvg('reviews', 'star')` dan `withCount('reviews')` menghasilkan atribut `reviews_avg_star` dan `reviews_count` yang dibaca komponen kartu.

### Contoh: halaman detail game

```php
public function show(Game $game)
{
    $game->loadMissing(['categories', 'tags', 'operatingSystems', 'images'])
         ->loadAvg('reviews', 'star')
         ->loadCount('reviews');

    $user = auth()->user();
    $owned = $user && OrderItem::where('game_id', $game->game_id)
        ->whereHas('order', fn ($q) => $q->where('user_id', $user->getKey())->where('status', 'paid'))
        ->exists();
    $reviewed = $user && $game->reviews()->where('user_id', $user->getKey())->exists();

    return view('games.show', [
        'game' => $game,
        'reviews' => $game->reviews()->with('user')->latest()->paginate(5, ['*'], 'ulasan')->fragment('ulasan'),
        'ratingBreakdown' => $game->reviews()->selectRaw('star, count(*) as total')->groupBy('star')->pluck('total', 'star')->all(),
        'reviewAccess' => match (true) {
            ! $user => 'guest',
            $reviewed => 'reviewed',
            $owned => 'allowed',
            default => 'must_buy',
        },
        'owned' => $owned,
        'inCart' => $user && Cart::where('user_id', $user->getKey())->where('game_id', $game->game_id)->exists(),
        'wishlisted' => $user && Wishlist::where('user_id', $user->getKey())->where('game_id', $game->game_id)->exists(),
        'similarGames' => Game::where('game_id', '!=', $game->game_id)->take(4)->get(),
    ]);
}
```

Controller `reviews.store` memeriksa ulang bahwa pengirimnya pembeli (aturan di bagian 7 kontrak), karena tampilan saja tidak mencegah POST langsung.

### Cara menguji tiap halaman

Buka halaman versi `preview` dan versi controller secara bergantian. Bentuknya harus sama. Kalau ada yang berbeda, penyebabnya hampir selalu nama variabel atau nama properti yang tidak cocok dengan kontrak.
