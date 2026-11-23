<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
 | Route asli (terhubung ke database). Nama route sama dengan docs/04-DATA-CONTRACT.md
 | sehingga view tidak perlu diubah. routes/preview.php (data contoh) tidak dipakai lagi.
 */

// ---------- Publik ----------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cari', [SearchController::class, 'index'])->name('search');
Route::get('/game/{id}', [GameController::class, 'show'])->name('games.show');
Route::get('/tentang', [PageController::class, 'about'])->name('about');

// ---------- Tamu (belum login) ----------
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [AuthController::class, 'login'])->name('login.store');
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register'])->name('register.store');
});

// ---------- Harus login ----------
Route::middleware('auth')->group(function () {
    Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

    Route::get('/keranjang', [CartController::class, 'index'])->name('cart');
    Route::post('/keranjang', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/keranjang/{game}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{game}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    Route::get('/koleksi', [LibraryController::class, 'index'])->name('collection');

    Route::post('/ulasan', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/profil', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profil/ubah', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    // Checkout (view-nya dikerjakan Maul)
    Route::get('/checkout/pembayaran', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::get('/checkout/tinjau', [CheckoutController::class, 'review'])->name('checkout.review');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/status', [CheckoutController::class, 'status'])->name('checkout.status');
});
