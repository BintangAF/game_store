# 03. Alur kerja

> **Status:** fondasi, Home, dan semua halaman selain checkout sudah terisi dengan data contoh. Checkout (pembayaran) dikerjakan Maul. Pembagian tim ada di `05-PEMBAGIAN-TIM.md`.

## A. Alur sebuah halaman (dari klik sampai tampil)

```
Browser
  -> routes/web.php            (nama route, mis. 'games.show')       [backend]
  -> Controller                (ambil data lewat Model dari database) [backend]
  -> return view('games.show', ['game' => $game, ...])
  -> views/games/show.blade.php         menyusun section               [frontend]
       @extends layouts/app   ->  partials (head, header, footer)
       @include sections/*    ->  components (<x-game.card />, <x-ui.button />)
  -> HTML jadi. CSS & JS datang dari Vite:  resources/css/app.css + resources/js/app.js
```

**Form** (login, ulasan, tambah ke keranjang): `<form method="POST" action="{{ route('...') }}">` + `@csrf` -> controller memvalidasi -> `redirect()` kembali membawa pesan -> `partials/flash.blade.php` menampilkannya.

**Alur beli sampai bayar (payment gateway):**

```
cart.index  ->  checkout.payment (pilih QRIS/Dana/dst)  ->  checkout.review (tinjau, centang setuju)
  -> POST checkout.store      [backend: buat order status 'pending', minta transaksi ke gateway]
  -> diarahkan ke halaman/QR gateway
  -> gateway memberi tahu backend (webhook)  [backend: order jadi 'paid']
  -> pengguna kembali ke checkout.status     ->  game muncul di Koleksi
```

Maul membuat tiga tampilan checkout (pilih metode, tinjau, status) dan menyambungkan gateway serta webhook. Bintang menyediakan data order dan statusnya.

## B. Siapa memegang apa

| Orang | Peran | Folder dan file |
|---|---|---|
| Lintar | Frontend | `resources/` (kecuali checkout), `routes/preview*.php`, `public/images`, `docs/` |
| Bintang | Backend | `app/`, `database/`, `config/`, `routes/web.php`, panel Filament |
| Maul | Pembayaran dan hosting | `views/checkout/*`, `views/components/checkout/*`, konfigurasi server |
| Neo | Data | file data game (`docs/template-data-game.csv`) dan gambar game |

Berkas bersama (`js/app.js`, `package.json`, `vite.config.js`, `.env.example`): `git pull` dulu dan kabari grup sebelum mengubahnya.

## C. Alur git harian (branch `frontend`)

```bash
git switch frontend
git pull origin frontend         # 1. selalu ambil terbaru dulu
# ... kerjakan satu bagian kecil ...
git add .
git commit -m "frontend: isi section calendar di home"
git push origin frontend         # 2. kirim ke GitHub
```

- Satu commit = satu bagian kecil (satu section, satu komponen). Pesan commit diawali `frontend:`.
- Kalau sebagian sudah rapi dan bisa dipakai backend, buka **Pull Request** `frontend` -> `main` di GitHub. Temanmu yang me-review dan merge.
- Setelah `main` berubah (backend merge), ambil ke branch-mu: `git switch frontend`, lalu `git merge main`.
- Kalau muncul **conflict**: buka file yang ditandai `<<<<<<<`, pilih isi yang benar, hapus tanda-tandanya, lalu `git add .` dan `git commit`. Kalau ragu, tanya sebelum memilih.
- Jangan commit `.env`, `vendor/`, `node_modules/`. Semuanya sudah ada di `.gitignore`.

## D. Alur mengerjakan SATU bagian (ulangi untuk tiap section/halaman)

1. **Buka kontrak data** (`docs/04-DATA-CONTRACT.md`) dan lihat variabel yang dipakai bagian itu.
2. **Buka file stub-nya.** Di komentar atas ada: halaman, data, JS, catatan.
3. **Isi markup** dengan kelas Tailwind dan warna dari tema. Bagian yang berulang (kartu game, tombol) jadikan **komponen**, jangan disalin.
4. **Beri data dummy** lewat `routes/preview.php`. Buat bentuknya sama persis dengan ERD, pakai objek: `(object) ['game_title' => 'Game 1', 'game_price' => 150000, ...]`. Dengan begitu saat diganti model asli, view tidak perlu diubah.
5. **Kalau butuh gerak** (carousel, dropdown), isi file modul JS-nya dan pasang `data-js="nama"` di HTML.
6. **Tes dua ukuran:** desktop (lebar penuh) dan HP (F12 > ikon HP, lebar sekitar 390px).
7. **Hapus** `<x-ui.todo ... />` dari file itu. Commit dan push.
8. Kalau ada variabel baru yang kamu butuhkan, **tambahkan ke kontrak data** dan kabari backend.

## E. Memindahkan HTML lama (`LINTAR_STORE_Merah_Hitam.html`) ke struktur baru

| Di file HTML lama | Sekarang |
|---|---|
| Variabel warna di `:root` | `css/theme.css` (palet 4 warna) |
| `<header>`, navbar biru `#sub` | `partials/header/top`, `store-nav`, `search-form`, `auth-links`, `cart-link` |
| `#drawer` dan fungsi `dr()` | `partials/header/mobile-drawer` dan checkbox `#drawer-toggle` di layout (tanpa JS) |
| Hover dan ketuk dropdown | `components/nav/dropdown` (hover dan fokus, tanpa JS) |
| `.hero`, `slide() go() show()` | `home/sections/featured-carousel` + `components/ui/carousel` + `js/modules/carousel.js` |
| Renderer JS `R.cap R.tc R.row R.tile` | `components/game/capsule`, `tag-card`, `list-row`, `components/ui/tile` |
| `tab()` dan `pv()` | `js/modules/tabs.js` + `home/sections/tabbed-list` (panel preview dibuang) |
| `step()` (checkout 2 langkah) | tiga halaman: `checkout/payment`, `review`, `status` |
| Tiap `<section class="page" id="...">` | satu folder view per halaman |
| Gradasi dummy `G(n)` dan `.cover` | `components/ui/placeholder` (warna datar) |
| Container `data-r="cap"` dll | `@foreach` + komponen |
| Array `games[]` | `pv_game()` di `routes/preview-data.php`, lalu variabel dari controller |
| `<footer>` | `partials/footer` |

Bagian yang dibuang karena ERD tidak punya data pendukungnya, atau terlalu ramai: Kalender Pribadimu, banner "Jelajahi daftar temanmu", "Dari pengembang yang kamu tahu", dua kartu lebar, banner promo, strip perkenalan, menu Bagian Spesial, panel preview, dan semua gradasi.

## F. Urutan pengerjaan yang disarankan

1. **Fondasi:** `theme.css`, font, `layouts/*`, `partials/head`, `header/*`, `footer`, `flash`.
2. **Komponen dasar:** `ui/button`, `chip`, `badge`, `section-title`, `panel`, `placeholder`, `form/*`.
3. **Komponen game:** `cover`, `price`, `rating`, `card`, `capsule`, `tag-card`, `list-row`, `developer-card`.
4. **Home:** sudah terisi. Cek tampilannya di desktop dan HP.
5. **Detail game** (`games/show` + sections).
6. **Pencarian** (`search/`).
7. **Login dan register.**
8. **Keranjang dan checkout** (3 halaman).
9. **Profil, Koleksi, Tentang, 404.**
10. **Responsif dan rapikan**, lalu **sambungkan data asli** bersama backend (hapus `preview.php` sedikit demi sedikit).

Urutan 1 sampai 3 sebaiknya selesai lebih dulu, karena semua halaman memakainya.

## G. Selesai berarti

- [ ] Tampil benar di desktop dan HP.
- [ ] Tidak ada kode warna langsung di Blade (semua dari tema).
- [ ] Tidak ada `<script>` di Blade, dan tidak ada `style=""` kecuali `--ph-h` untuk placeholder (JS lewat `data-js`, gaya lewat Tailwind).
- [ ] Bagian berulang sudah jadi komponen.
- [ ] Variabel yang dipakai sudah tertulis di kontrak data.
- [ ] `<x-ui.todo>` sudah dihapus dari file itu.
