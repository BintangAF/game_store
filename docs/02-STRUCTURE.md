# 02. Struktur folder

Penjelasan tiap file ada di `07-PETA-FILE.md`.

Aturan utamanya: **satu file = satu tanggung jawab**. Mau mengubah sesuatu, kamu tahu persis file mana yang dibuka, tanpa mencari di satu file besar.

## Peta folder (milik frontend)

```
resources/
├── css/
│   ├── app.css              pintu masuk, hanya berisi @import
│   ├── theme.css            semua warna dan font (palet 4 warna)
│   ├── base.css             gaya dasar (fokus, overflow)
│   └── components/
│       └── placeholder.css  placeholder netral dan datar
├── js/
│   ├── app.js               daftar modul
│   ├── core/boot.js         pemasang modul lewat atribut data-js="..."
│   └── modules/             carousel.js  tabs.js  gallery.js  game-tip.js  scroller.js
└── views/
    ├── layouts/             app, auth, checkout
    ├── partials/            head, footer, flash, header/*
    ├── components/          game/ ui/ form/ nav/ cart/ checkout/ review/
    ├── home/                index + sections/ (8 potongan)
    ├── games/               show + sections/ (6 potongan)
    └── auth/ cart/ checkout/ collection/ about/ search/ profile/ wishlist/ errors/
public/images/               brand, placeholder, banners, icons, payment
routes/preview.php           route sementara untuk melihat halaman tanpa backend
routes/preview-data.php      data contoh (Game 1, Game 2, ...)
docs/                        panduan ini
```

Dropdown navbar dan menu samping mobile tidak memakai JS. Dropdown terbuka lewat hover dan fokus (Tailwind `group`), menu samping lewat checkbox `#drawer-toggle` (Tailwind `peer`).

Folder milik backend (jangan diubah tanpa memberi tahu): `app/`, `database/`, `routes/web.php`, `config/`, panel admin Filament.
Folder `views/checkout/` dan `views/components/checkout/` dikerjakan Maul (pembayaran).

## Aturan penamaan

- File Blade: huruf kecil dan tanda hubung, misalnya `buy-box.blade.php`.
- Pemanggilan komponen mengikuti foldernya: `components/game/card.blade.php` dipanggil `<x-game.card :game="$game" />`.
- Section dipanggil dengan `@include('home.sections.calendar')`.
- Halaman hanya **menyusun** section. Isi markup ada di section dan komponen, bukan di halaman.
- Warna **hanya** dari `theme.css` (`bg-base`, `bg-panel`, `text-fg`, `text-muted`, `border-line`, `bg-accent`, `text-accent-2`). Jangan menulis kode warna langsung di Blade.
- Perilaku JS dipasang lewat atribut: `<div data-js="carousel">`. Tidak ada `<script>` di dalam file Blade.
- CSS khusus dibuat hanya jika utilitas Tailwind tidak cukup. Buat file di `css/components/` lalu `@import` di `app.css`.

## Mau ubah X, buka file Y

| Mau mengubah | Buka |
|---|---|
| Warna, font | `css/theme.css` |
| Isi menu atas (Home, Koleksi, ...) | `views/partials/header/top.blade.php` |
| Menu biru (Telusuri, Kategori, ...) | `views/partials/header/store-nav.blade.php` |
| Tombol Masuk/Daftar | `views/partials/header/auth-links.blade.php` |
| Footer | `views/partials/footer.blade.php` |
| Banner carousel (tampilan) | `views/home/sections/featured-carousel.blade.php` |
| Banner carousel (tombol geser) | `js/modules/carousel.js` dan `views/components/ui/carousel.blade.php` |
| Menu samping mobile | `views/partials/header/mobile-drawer.blade.php` |
| Dropdown navbar | `views/components/nav/dropdown.blade.php` |
| Data contoh preview | `routes/preview-data.php` |
| Bentuk kartu game | `views/components/game/card.blade.php` (atau `capsule`, `tag-card`, `list-row`) |
| Urutan section di Home | `views/home/index.blade.php` |
| Form login | `views/auth/login.blade.php` |
| Langkah checkout | `views/checkout/payment.blade.php`, `review.blade.php`, `status.blade.php` |
| Pilihan metode bayar | `views/components/checkout/payment-option.blade.php` |
| Tampilan placeholder gambar | `css/components/placeholder.css` |
