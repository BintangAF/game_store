<?php

/*
  ROUTE SEMENTARA UNTUK FRONTEND (milik frontend).
  Tujuan: membuka semua halaman tanpa menunggu backend.
  Saat controller backend sudah ada, hapus route yang sama di sini dan pindahkan ke routes/web.php.
  Aktifkan dengan menambah di akhir routes/web.php:  require __DIR__.'/preview.php';
  (beri komentar pada route '/' bawaan welcome di web.php agar tidak bentrok)
*/

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

require_once __DIR__.'/preview-data.php';

View::share([
    'cartCount' => 2,
    'navCategories' => pv_categories(),
]);

$paymentMethods = [
    'qris' => 'QRIS',
    'dana' => 'Dana',
    'ovo' => 'OVO',
    'gopay' => 'GoPay',
    'bank_transfer' => 'Transfer Bank (Virtual Account)',
    'card' => 'Visa / MasterCard',
];

// ---------- Halaman (GET) ----------
Route::get('/', fn () => view('home.index', [
    'featured' => pv_games(1, 5),
    'categories' => pv_categories(),
    'recommendedByLibrary' => pv_games(6, 5),
    'becauseOf' => pv_game(2),
    'becauseOfGames' => pv_games(7, 4),
    'tagBlocks' => collect([
        (object) ['id' => 1, 'name' => 'Kategori 1', 'games' => pv_games(1, 4)],
        (object) ['id' => 2, 'name' => 'Kategori 2', 'games' => pv_games(5, 4)],
    ]),
    'newReleases' => pv_games(3, 4),
    'tabs' => [
        'newest' => ['label' => 'Rilisan terbaru', 'games' => pv_games(1, 8)],
        'bestsellers' => ['label' => 'Terlaris', 'games' => pv_games(4, 8)],
        'upcoming' => ['label' => 'Populer dan mendatang', 'games' => pv_games(8, 8)],
    ],
    'underPrice' => pv_games(4, 5),
]))->name('home');

Route::get('/masuk', fn () => view('auth.login'))->name('login');
Route::get('/daftar', fn () => view('auth.register'))->name('register');
Route::get('/koleksi', fn () => view('collection.index', ['library' => pv_games(1, 6)]))->name('collection');
Route::get('/tentang', fn () => view('about.index'))->name('about');

Route::get('/cari', fn () => view('search.index', [
    'games' => new LengthAwarePaginator(pv_games(1, 9), 27, 9, 1, ['path' => url('/cari')]),
    'query' => request('q'),
    'filters' => request()->only(['q', 'category', 'os', 'max_price', 'sort']),
    'categories' => pv_categories(),
    'operatingSystems' => pv_os(),
]))->name('search');

Route::get('/game/{id}', function ($id) {
    // Bawaan: belum ada ulasan (database belum ada).
    // Untuk melihat tampilan berisi: /game/1?contoh_ulasan=25
    // Untuk melihat status penulis ulasan: ?akses=guest | must_buy | allowed | reviewed
    $all = pv_reviews(max(0, (int) request('contoh_ulasan', 0)));
    $page = max(1, (int) request('ulasan', 1));

    $game = pv_game((int) $id);
    $game->reviews_count = $all->count();
    $game->reviews_avg_star = $all->count() ? round($all->avg('star'), 1) : null;

    return view('games.show', [
        'game' => $game,
        // Bentuk yang sama dengan hasil ->paginate(5, ['*'], 'ulasan') dari controller.
        'reviews' => (new LengthAwarePaginator($all->forPage($page, 5)->values(), $all->count(), 5, $page, [
            'path' => url()->current(),
            'pageName' => 'ulasan',
        ]))->fragment('ulasan'),
        'ratingBreakdown' => collect([5, 4, 3, 2, 1])->mapWithKeys(fn ($s) => [$s => $all->where('star', $s)->count()])->all(),
        'reviewAccess' => request('akses', 'must_buy'),
        'owned' => false,
        'inCart' => false,
        'wishlisted' => false,
        'similarGames' => pv_games(2, 4),
    ]);
})->name('games.show');

Route::get('/keranjang', fn () => view('cart.index', [
    'items' => pv_cart_items(),
    'total' => 970000,
]))->name('cart');

Route::get('/wishlist', fn () => view('wishlist.index', ['wishlist' => pv_games(3, 4)]))->name('wishlist');

Route::get('/checkout/pembayaran', fn () => view('checkout.payment', [
    'paymentMethods' => $paymentMethods,
    'buyer' => (object) ['name' => 'Username', 'email' => 'email@contoh.com'],
]))->name('checkout.payment');

Route::get('/checkout/tinjau', function () use ($paymentMethods) {
    $code = array_key_exists(request('payment_method'), $paymentMethods) ? request('payment_method') : 'qris';

    return view('checkout.review', [
        'items' => pv_cart_items(),
        'total' => 970000,
        'paymentMethod' => (object) ['code' => $code, 'label' => $paymentMethods[$code]],
    ]);
})->name('checkout.review');

Route::get('/checkout/status', fn () => view('checkout.status', [
    'order' => (object) ['order_id' => 1001, 'status' => request('status', 'pending'), 'total_amount' => 970000, 'payment_method' => 'QRIS'],
]))->name('checkout.status');

Route::get('/profil', fn () => view('profile.show', [
    'user' => pv_user(),
    'library' => pv_games(1, 4),
    'orders' => pv_orders(),
]))->name('profile');

Route::get('/profil/ubah', fn () => view('profile.edit', ['user' => pv_user()]))->name('profile.edit');

// ---------- Aksi (POST/PUT/DELETE): hanya menjawab kembali, backend yang mengisi ----------
$stub = fn () => back()->with('status', 'Ini route sementara untuk preview.');

Route::post('/masuk', $stub)->name('login.store');
Route::post('/daftar', $stub)->name('register.store');
Route::post('/keluar', $stub)->name('logout');
Route::post('/keranjang', $stub)->name('cart.store');
Route::delete('/keranjang/{game}', $stub)->name('cart.destroy');
Route::post('/wishlist', $stub)->name('wishlist.store');
Route::delete('/wishlist/{game}', $stub)->name('wishlist.destroy');
Route::post('/checkout', fn () => redirect()->route('checkout.status'))->name('checkout.store');
Route::post('/ulasan', $stub)->name('reviews.store');
Route::put('/profil', $stub)->name('profile.update');
