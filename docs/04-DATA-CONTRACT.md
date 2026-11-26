# 04. Kontrak data (frontend <-> backend)

Dokumen ini berisi **variabel yang diharapkan setiap view**. Frontend menulis view memakai nama ini, backend menyediakannya dari controller. Kalau ada yang berubah, ubah dokumen ini dulu, lalu kabari satu sama lain.

Nama kolom mengikuti ERD terbaru (sudah ada tabel `wishlists`).

## 1. Bentuk objek `$game`

```
$game->game_id
$game->game_title
$game->game_price            decimal; 0 berarti gratis
$game->game_desc
$game->cover_image_path      path relatif; tampil lewat Storage::url()
$game->release_date
$game->system_requirements
$game->developer_name
$game->publisher_name
$game->categories            koleksi -> category_name
$game->tags                  koleksi -> tag_name
$game->operatingSystems      koleksi -> os_name
$game->images                koleksi -> image_path, sort_order   (tabel game_images)
$game->reviews_avg_star      rata-rata bintang  (withAvg('reviews', 'star'))
$game->reviews_count         jumlah ulasan      (withCount('reviews'))
```

Objek lain: `$review` (star, body, user->username, created_at), `$order` (order_id, total_amount, status, payment_method, created_at, items), `$orderItem` (game, price_at_purchase).

## 2. Variabel global (semua halaman, lewat View Composer)

| Variabel | Isi |
|---|---|
| `auth()->user()` | pengguna login atau null |
| `$cartCount` | jumlah item di keranjang (angka) |
| `$navCategories` | daftar kategori untuk dropdown Kategori |
| `$headerNotices` | pemberitahuan yang bergeser di header: tiap item `label`, `tone` (accent, sage, muted), `text`, `href`. Kosong = tidak tampil | `App\Support\HeaderNotices::get()` (pembeli terbanyak dari pesanan `paid`, dan game dengan `release_date` di depan) |

## 3. Variabel per halaman

Contoh nilainya ada di `routes/preview.php`.

| View | Variabel | Isi | Sumber |
|---|---|---|---|
| `home.index` | `$featured` | 5 game unggulan (carousel) | games |
| | `$categories` | semua kategori | categories |
| | `$recommendedByLibrary` | 5 game serupa dengan yang dimiliki | lihat bagian 5 |
| | `$becauseOf`, `$becauseOfGames` | 1 game dimiliki + 4 game bertag serupa | order_items, game_tag |
| | `$tagBlocks` | 2 blok: `id`, `name`, `games` (4 game) | categories / tags |
| | `$newReleases` | 4 game rilis terbaru | games (urut release_date) |
| | `$tabs` | `['kunci' => ['label' => ..., 'games' => 8 game]]`, kunci: newest, bestsellers, upcoming | games, order_items |
| | `$underPrice` | 5 game harga <= 90000 | games |
| `games.show` | `$game` | objek lengkap (bagian 1) | games + relasi |
| | `$reviews` | paginator, 5 per halaman, nama halaman `ulasan`: `$game->reviews()->with('user')->latest()->paginate(5, ['*'], 'ulasan')->fragment('ulasan')` | reviews |
| | `$ratingBreakdown` | jumlah ulasan per bintang: `[5 => n, 4 => n, 3 => n, 2 => n, 1 => n]` | reviews (`GROUP BY star`) |
| | `$reviewAccess` | `guest`, `must_buy`, `allowed`, atau `reviewed` (lihat bagian 7) | users, order_items, reviews |
| | `$owned`, `$inCart`, `$wishlisted` | boolean | order_items, carts, wishlists |
| | `$similarGames` | 4 game | game_category |
| `search.index` | `$games` | hasil (paginate) | games |
| | `$query`, `$filters` | `q`, `category`, `os`, `max_price`, `sort` | request |
| | `$categories`, `$operatingSystems` | isi filter (`category_id`, `os_id`) | tabel master |
| `cart.index` | `$items`, `$total` | tiap item punya `->game`; total berupa angka | carts + games |
| `wishlist.index` | `$wishlist` | game di wishlist pengguna | wishlists + games |
| `checkout.payment` | `$paymentMethods`, `$buyer` | `['kode' => 'Nama']`; `name`, `email` | konfigurasi |
| `checkout.review` | `$items`, `$total`, `$paymentMethod` | `$paymentMethod->code` dan `->label` | carts, request |
| `checkout.status` | `$order` | `order_id`, `status`, `total_amount`, `payment_method` | orders |
| `collection.index` | `$library` | game dari order berstatus `paid` | order_items |
| `profile.show` | `$user`, `$library`, `$orders` | order punya `items` (tiap item `->game`) | users, orders |
| `profile.edit` | `$user` | | users |
| `auth.login`, `auth.register` | - | form saja | |

## 4. Route dan nama field form

| Nama route | Method | Keterangan |
|---|---|---|
| `home`, `collection`, `about`, `search`, `cart`, `profile`, `profile.edit` | GET | halaman biasa |
| `games.show` | GET | `/game/{id}` |
| `checkout.payment`, `checkout.review`, `checkout.status` | GET | tiga langkah checkout |
| `login`, `register` | GET | tampilan form |
| `login.store` | POST | field: `login`, `password`, `remember` |
| `register.store` | POST | field: `username`, `email`, `password`, `password_confirmation` |
| `logout` | POST | |
| `cart.store` | POST | field: `game_id` |
| `cart.destroy` | DELETE | `/keranjang/{game}` |
| `wishlist` | GET | `/wishlist` |
| `wishlist.store` | POST | field: `game_id` |
| `wishlist.destroy` | DELETE | `/wishlist/{game}` |
| `checkout.review` | GET | query: `payment_method`, `buyer_name`, `buyer_email` |
| `checkout.store` | POST | field: `payment_method`, `agree`. Buat order `pending`, mulai pembayaran gateway |
| `reviews.store` | POST | field: `game_id`, `star`, `body` |
| `profile.update` | PUT | field: `username`, `email` |

Parameter pencarian: `q`, `category`, `os`, `max_price`, `sort` (`relevant`, `newest`, `cheapest`, juga `bestseller` dan `popular` dari menu).

## 5. Hal yang belum ada di ERD (perlu diputuskan bersama)

| # | Masalah | Usulan |
|---|---|---|
| 1 | **Diskon.** Komponen harga membaca `$game->discount_percent` (boleh kosong), tapi `games` belum punya kolom itu. | Tambah `discount_percent` (nullable) di `games`. Tanpa kolom itu, label diskon tidak tampil. |
| 2 | **Game gratis.** Tidak ada penanda. | Pakai `game_price = 0`. View menampilkan "Gratis". |
| 3 | **Tanggal.** Riwayat transaksi, tanggal bergabung, dan ulasan memakai `created_at`. | Pastikan `users`, `orders`, `reviews` punya `timestamps()`. |
| 4 | **Info payment gateway.** `orders` punya `status` dan `payment_method`, tapi belum punya referensi transaksi gateway. | Tambah `payment_reference` dan `paid_at` di `orders`. |
| 5 | **Nama kolom user.** ERD memakai `user_id` dan `username`. Bawaan Laravel memakai `id` dan `name`. | Sepakati satu versi. View membaca `username` lebih dulu, lalu `name`. Ikut konvensi Laravel (`id`) lebih sederhana. |
| 6 | **Rekomendasi.** Tidak ada data bermain atau unduhan. | Pakai pembelian (`order_items` dari order `paid`). Rekomendasi = game berkategori atau bertag sama dengan yang dimiliki. |
| 7 | **Keranjang.** `carts` tidak punya jumlah. | Cocok untuk game digital. Tambah unique `(user_id, game_id)`. |
| 8 | **Gambar.** `cover_image_path` dan `game_images.image_path`. | Simpan di disk `public`, jalankan `php artisan storage:link`. View memakai `Storage::url()`. |
| 9 | **Isi menu.** Kategori di dropdown dan menu samping datang dari `$navCategories`. | Bagikan lewat View Composer atau `AppServiceProvider`. |

## 6. Sepuluh entitas database dan pemakaiannya di frontend

| # | Entitas | Tabel di ERD | Dipakai di | Catatan |
|---|---|---|---|---|
| 1 | User | `users` | login, register, profil, header | Bintang membuat tabel dan auth. |
| 2 | Role | `roles` | akses panel admin | Frontend tidak menampilkannya. |
| 3 | Cart | `carts` | keranjang, badge header, kotak beli | |
| 4 | Wishlist | `wishlists` | halaman wishlist, kotak beli | |
| 5 | Game | `games`, `game_images` | semua halaman | Neo menyetor datanya. |
| 6 | Review | `reviews` | detail game | |
| 7 | Kategori | `categories`, `game_category` | dropdown, filter, kotak kategori | Neo menyetor datanya. |
| 8 | Tag | `tags`, `game_tag` | chip, kartu bertag | Neo menyetor datanya. |
| 9 | Operating system | `operating_systems`, `game_os` | filter, spesifikasi sistem | Neo menyetor datanya. |
| 10 | Pesanan | `orders`, `order_items` | koleksi, riwayat di profil, checkout | Checkout dikerjakan Maul. |

Role dan akun admin awal dibuat Bintang lewat seeder (usulan). Cart, wishlist, review, dan pesanan terisi saat pengguna memakai situs.

## 7. Aturan ulasan dan rating

Frontend menampilkan formulir hanya saat `$reviewAccess` bernilai `allowed`. Aturan sebenarnya dijalankan backend, karena tampilan saja tidak cukup untuk mencegah pengiriman dari non-pembeli.

| Keadaan | `$reviewAccess` | Tampilan |
|---|---|---|
| Belum login | `guest` | Ajakan masuk dan membeli |
| Login, belum membeli game ini | `must_buy` | "Beli game ini untuk menulis ulasan" |
| Sudah membeli (order `paid` yang berisi game ini) dan belum menulis | `allowed` | Formulir bintang dan teks |
| Sudah menulis | `reviewed` | "Kamu sudah menulis ulasan" |

Aturan untuk `reviews.store` (POST):
- Wajib login dan wajib punya `order_items` dari order berstatus `paid` untuk `game_id` itu. Jika tidak, tolak (403 atau redirect dengan pesan).
- `star` wajib, bilangan bulat 1 sampai 5. `body` boleh kosong.
- Satu pengguna satu ulasan per game. Usulan: unique `(user_id, game_id)`.

Cara menghitung rating, seperti sistem rating pada umumnya:
- Rata-rata = `AVG(reviews.star)` dari semua ulasan game itu, ditampilkan satu angka desimal (`withAvg('reviews', 'star')`). Dihitung ulang setiap kali dibaca, jadi tidak perlu kolom tersimpan.
- Jumlah ulasan = `COUNT(reviews)` (`withCount('reviews')`).
- Sebaran per bintang = jumlah ulasan untuk tiap nilai 5 sampai 1 (`$ratingBreakdown`).
- Game tanpa ulasan: `reviews_count = 0` dan `reviews_avg_star = null`. Tampilan menulis "0,0" dan "Belum ada ulasan".

Mengoper ulasan lewat data contoh: `/game/1?contoh_ulasan=25` menampilkan 25 ulasan, dan `?akses=allowed` menampilkan formulirnya.
