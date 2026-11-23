# 01. Setup di laptop

Ikuti urutannya dari atas. Perintah dijalankan di terminal (Laragon: tombol Terminal, atau PowerShell/Git Bash).

## 0. Yang harus terpasang

| Alat | Versi | Cek dengan |
|---|---|---|
| Git | terbaru | `git --version` |
| PHP | 8.3 ke atas (`composer.json` meminta `^8.3`) | `php -v` |
| Composer | terbaru | `composer -V` |
| Node.js + npm | versi LTS terbaru | `node -v` dan `npm -v` |

Cara termudah di Windows: pasang **Laragon Full**. PHP, Composer, Node, dan Git sudah ikut.

Project ini memakai **Filament**, jadi ekstensi PHP `intl` harus aktif. Cek dengan `php -m` dan cari `intl`. Kalau tidak ada, aktifkan `extension=intl` di `php.ini` (Laragon: menu > PHP > php.ini), lalu restart.

## 1. Ambil project dan pindah ke branch frontend

```bash
git clone https://github.com/BintangAF/game_store.git
cd game_store
git branch -r              # lihat daftar branch di GitHub
git switch frontend        # pindah ke branch frontend
```

Kalau branch `frontend` belum ada di daftar, buat dari `main`: `git switch -c frontend`, lalu `git push -u origin frontend`.

## 2. Pasang dependensi dan siapkan .env

```bash
composer install
npm install
copy .env.example .env       # Mac/Linux: cp .env.example .env
php artisan key:generate
php artisan migrate
```

- Di README temanmu ada tanda backtick (`) nyasar di akhir `php artisan key:generate`. **Jangan ikut diketik.**
- Database sementara memakai **sqlite** (sudah jadi default di `.env.example`). Kalau `migrate` bertanya "create the SQLite database?", jawab **yes**.
- Nanti saat backend memakai MySQL, temanmu yang memberi tahu isi `.env`-nya. `.env` tidak ikut di-commit.

## 3. Pasang kerangka frontend dari zip ini

1. Ekstrak `frontend-scaffold.zip`.
2. Salin folder `resources`, `public/images`, dan `docs`, serta file `routes/preview.php` dan `routes/preview-data.php`, ke root project. Kalau ditanya timpa `resources/css/app.css` dan `resources/js/app.js`, pilih **timpa** (memang sengaja).
3. Buka `routes/web.php`. Beri komentar pada route `/` bawaan (yang memanggil `welcome`), lalu tambahkan di baris paling bawah:

```php
require __DIR__.'/preview.php';
```

`preview.php` adalah route sementara milik frontend supaya semua halaman bisa dibuka tanpa menunggu backend. Isinya dihapus bertahap saat controller backend sudah ada.

## 4. Jalankan

Buka dua terminal di folder project:

```bash
npm run dev          # terminal 1: biarkan jalan (Vite + Tailwind)
php artisan serve    # terminal 2
```

Buka http://127.0.0.1:8000. Kamu melihat halaman Home dengan banner, kategori, dan baris game contoh (Game 1, Game 2, dan seterusnya). Halaman checkout masih kerangka karena dikerjakan Maul. Cek juga `/masuk`, `/game/1`, `/keranjang`, `/checkout/pembayaran`, `/profil`.

## 5. Setelan sekali saja

**Font (Inter).** Di `vite.config.js`, ganti `bunny('Instrument Sans', ...)` menjadi:

```js
bunny('Inter', { weights: [400, 600, 700, 800, 900] }),
```

**Template / plugin Tailwind.** Project ini memakai Tailwind v4, yang **tidak punya `tailwind.config.js`**. Pengaturan ada di CSS. Contoh memasang library komponen (cek dokumentasi resminya untuk versi terbaru):

```bash
npm i -D daisyui            # lalu di resources/css/app.css tambah:  @plugin "daisyui";
npm i flowbite              # lalu tambah:  @plugin "flowbite/plugin";  dan  @source "../../node_modules/flowbite";
```

Template yang dicopy dari internet biasanya berisi warna bawaannya (misalnya `bg-blue-600`). Ganti ke nama dari tema kita (`bg-accent`, `bg-panel`, `text-fg`, ...) supaya warna tetap satu sumber di `resources/css/theme.css`.

**Gambar cover game dari backend.** Backend menyimpan file di `storage/app/public`. Agar bisa tampil: `php artisan storage:link` (sekali per laptop).

## 6. Soal file AGENTS.md dan CLAUDE.md

Dua file itu dibuat otomatis oleh Laravel Boost dan isinya perintah untuk **agen AI** (memasang paket `laravel/boost`). Itu bukan bagian tugas frontend. Abaikan saja, tidak perlu dijalankan.

## Masalah yang sering muncul

| Pesan error | Penyebab dan solusi |
|---|---|
| `Vite manifest not found` | `npm run dev` belum jalan. Jalankan, atau `npm run build` sekali. |
| `requires ext-intl` | Aktifkan ekstensi `intl` di php.ini. |
| `could not find driver` / sqlite | Aktifkan `pdo_sqlite` dan `sqlite3` di php.ini. |
| Halaman putih / error 500 | Lihat `storage/logs/laravel.log`. |
| Perubahan CSS tidak muncul | Pastikan `npm run dev` masih jalan, lalu refresh keras (Ctrl+F5). |
