# 05. Pembagian tim dan serah terima

## 1. Pembagian

| Orang | Peran | Tugas |
|---|---|---|
| **Bintang** | Backend | Database (10 entitas), controller dan route, login, panel admin (Filament). |
| **Lintar** | Frontend | Semua tampilan selain checkout: layout, komponen, Home, detail game, pencarian, login dan daftar, keranjang, wishlist, koleksi, profil, tentang. Menyambungkan view ke data bersama Bintang. |
| **Neo** | Data | Mencari data game dari daftar yang dibuat Bintang, menyetornya ke Bintang, dan mengisi konten frontend (deskripsi dan sejenisnya). Bentuk akhirnya diputuskan nanti. |
| **Maul** | Hosting dan pembayaran | Tiga halaman checkout, integrasi payment gateway, status pembayaran, hosting dan deploy. |

Maul memegang seluruh bagian pembayaran. Halaman dan komponen checkout di project sengaja dikosongkan untuknya.

## 2. Urutan kerja

1. **Frontend selesai** dengan data contoh (Lintar). Tahap ini hampir tuntas.
2. **Sambungkan ke database** (Bintang dan Lintar). Route di `routes/preview.php` dipindahkan ke controller, data contoh diganti data asli.
3. **Panel admin** (Bintang).
4. **Isi data game** (Neo) lewat panel admin atau seeder.
5. **Pembayaran dan hosting** (Maul).

Neo bisa mulai mencari data sejak sekarang. Maul bisa membaca kerangka checkout dan `04-DATA-CONTRACT.md` sejak sekarang.

## 3. Serah terima

### Lintar ke Bintang
- `04-DATA-CONTRACT.md`: variabel tiap halaman, nama field form, nama route, dan 10 entitas database.
- `routes/preview.php`: peta route lengkap. Setiap route di sana menjadi satu method controller.
- `routes/preview-data.php`: bentuk objek yang diharapkan view. Controller mengirim objek dengan nama properti yang sama.
- Hal yang perlu diputuskan: lihat bagian 5 di `04-DATA-CONTRACT.md` (diskon, timestamps, referensi gateway, nama kolom user).

### Bintang ke Neo
Daftar game yang dicari, ditambah daftar kategori, tag, dan sistem operasi yang boleh dipakai.

### Neo ke Bintang
Isi `docs/template-data-game.csv`, satu baris per game. Batas panjang mengikuti ERD:

| Kolom | Batas |
|---|---|
| `game_title` | 100 karakter |
| `game_price` | angka rupiah, tanpa titik. `0` berarti gratis |
| `game_desc`, `system_requirements` | teks bebas |
| `release_date` | `YYYY-MM-DD` |
| `developer_name`, `publisher_name` | 50 karakter |
| kategori, tag, sistem operasi | dipisah titik koma. Ambil dari daftar Bintang, tiap nama maksimal 30 karakter |
| `cover_image` | satu file, rasio 16:9 (tampilan memakai rasio itu) |
| `gallery_images` | beberapa file, dipisah titik koma |

Nama file gambar memakai huruf kecil dan tanda hubung, misalnya `game-1-cover.jpg`. Gambar diserahkan ke Bintang bersama CSV.

Konten yang tidak punya kolom di ERD (video trailer, banner promo, teks Tentang) belum diputuskan tempatnya. Putuskan bersama sebelum Neo mengisinya.

### Lintar ke Maul
File milik Maul:
- `views/checkout/payment.blade.php`, `review.blade.php`, `status.blade.php`
- `views/components/checkout/stepper`, `payment-option`, `order-summary`

Komentar di atas tiap file berisi route, data, komponen yang dipakai, dan catatan. Maul mengikuti `06-PANDUAN-STYLE.md` dan memakai komponen yang sudah ada (`ui/panel`, `ui/button`, `form/*`, `game/cover`, `game/price`).

Alurnya:
```
cart.index -> checkout.payment (pilih metode) -> checkout.review (tinjau)
  -> POST checkout.store : buat order status pending, minta transaksi ke gateway
  -> pengguna membayar di halaman atau QR gateway
  -> gateway memberi tahu server (webhook) : order menjadi paid atau failed
  -> checkout.status menampilkan hasilnya, game muncul di Koleksi
```

Yang Maul butuhkan dari Bintang: kolom `payment_reference` dan `paid_at` di `orders`, dan route webhook.

### Daftar cek hosting (Maul)
- PHP 8.3 atau lebih baru, dengan ekstensi `intl` (dipakai Filament).
- Jalankan `npm run build` dan `composer install --no-dev`. Server tidak memakai `npm run dev`.
- `.env` produksi: `APP_ENV=production`, `APP_DEBUG=false`, isi database, `APP_URL`.
- Hapus baris `require __DIR__.'/preview.php';` di `routes/web.php`.
- `php artisan migrate --force` dan `php artisan storage:link`.

## 4. Yang belum diputuskan

| Hal | Perlu diputuskan oleh |
|---|---|
| Bentuk akhir konten frontend dari Neo (deskripsi dan sejenisnya) | Neo, Bintang, Lintar |
| Kolom diskon di `games` | Bintang dan Lintar |
| `payment_reference` dan `paid_at` di `orders` | Bintang dan Maul |
| `user_id` atau `id`, `username` atau `name` | Bintang dan Lintar |
| Penyedia payment gateway | Maul |
