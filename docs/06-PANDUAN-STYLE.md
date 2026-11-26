# 06. Panduan style: mengikuti Home

Halaman baru disusun dari komponen yang sudah ada, tanpa menulis gaya dari nol. Panduan ini berlaku untuk Lintar dan untuk Maul yang mengisi halaman checkout. Home adalah contoh yang sudah jadi: buka `views/home/` dan `views/components/` untuk melihat polanya.

Gaya mengikuti `viret.html`: kaca transparan di atas latar ungu gelap, aksen teal dan merah, sudut membulat, bentuk pil untuk menu dan label, bayangan lembut. Semua itu sudah tertanam di komponen dan tema, jadi kamu cukup memanggil komponennya.

## 1. Cara menyusun halaman

1. Buka file kerangkamu. Baca komentar di atas: route, data, komponen, acuan.
2. Buka halaman di browser lewat route preview (data contoh sudah tersedia).
3. Ganti `<x-ui.todo ... />` dengan markup yang disusun dari komponen.
4. Cek di desktop dan HP (F12, ikon HP, lebar 390px).
5. Hapus `<x-ui.todo>`, commit, push, buka PR.

Contoh halaman lengkap (Koleksi):

```blade
@extends('layouts.app')
@section('title', 'Koleksi')
@section('content')
    <h1 class="mb-4 text-2xl font-bold">Koleksi saya</h1>

    @if (count($library))
        <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
            @foreach ($library as $game)
                <x-game.card :game="$game" />
            @endforeach
        </div>
    @else
        <x-ui.empty-state title="Koleksi masih kosong" :href="route('search')" action="Cari game" />
    @endif
@endsection
```

Contoh form di dalam panel:

```blade
<x-ui.panel>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')
        <x-form.input name="username" label="Username" />
        <x-ui.button type="submit">Simpan</x-ui.button>
    </form>
</x-ui.panel>
```

## 2. Katalog komponen

| Komponen | Props | Fungsi |
|---|---|---|
| `<x-ui.button>` | `href`, `variant` (primary, teal, outline, ghost, danger), `size` (sm, md, lg), `block` | Semua tombol dan tautan tombol. Di dalam form, pakai `type="submit"`. |
| `<x-ui.panel>` | `class` | Kotak kaca (border tipis, blur, bayangan). |
| `<x-ui.section-title>` | `title`, `eyebrow`, `subtitle`, `href`, `linkText` | Judul section dengan label kecil teal di atasnya dan tombol "Lihat semua". |
| `<x-ui.chip>` | `href`, `tone` (teal, tag, os) | Label bentuk pil: kategori (teal), tag (netral), sistem operasi (merah). |
| `<x-ui.badge>` | `tone` (accent, sage, muted) | Lencana kecil, misalnya "-30%". |
| `<x-ui.tile>` | `category` | Kotak kategori. |
| `<x-ui.horizontal-row>` | `cols` | Baris kartu: geser samping di HP, grid di desktop. Contoh `cols="lg:grid-cols-4"`. |
| `<x-ui.scroller>` | - | Baris yang bisa digeser: 5 item di desktop, tombol kiri/kanan, titik halaman, swipe di HP. Dipakai untuk kotak kategori. |
| `<x-ui.ticker>` | `items` | Pemberitahuan yang bergeser di header, satu per satu dan berputar. Data dari `$headerNotices`. |
| `<x-ui.carousel>` | `autoplay` (ms, 0 untuk mematikan) | Carousel loop tanpa ujung dengan geser otomatis, slide samping terlihat sebagai preview (klik untuk pindah), titik, tombol, dan swipe. Isi = satu elemen per slide. |
| `<x-ui.empty-state>` | `title`, `message`, `href`, `action` | Tampilan kosong. |
| `<x-ui.placeholder>` | `hue`, `label` | Gambar pengganti netral. |
| `<x-form.input>` | `name`, `label`, `type`, `value` | Input teks dengan label dan pesan error. |
| `<x-form.select>` | `name`, `label`, `options`, `selected`, `placeholder` | Dropdown. `options` berbentuk `['nilai' => 'Teks']`. |
| `<x-form.checkbox>` | `name`, `label` | Checkbox. |
| `<x-ui.brand>` | - | Logo LINTAR.STORE. |
| `<x-nav.link>` | `href`, `active` | Tautan menu berbentuk pil. |
| `<x-nav.dropdown>` | `label`, `href`, `wide` | Dropdown navbar. |
| `<x-game.cover>` | `game`, `class` | Cover game, atau placeholder jika kosong. |
| `<x-game.price>` | `game` | Harga, diskon, atau "Gratis". |
| `<x-game.rating>` | `average`, `count` | Bintang rata-rata dan jumlah ulasan. |
| `<x-game.card>` | `game`, `wish` | Kartu game: cover, rating, tombol hati (wishlist), judul, chip, harga, tombol Detail. `:wish="false"` menyembunyikan tombol hati. |
| `<x-game.capsule>` | `game` | Kapsul ringkas: cover, judul, harga. |
| `<x-game.tag-card>` | `game` | Kartu dengan tag di bawah cover. |
| `<x-game.list-row>` | `game` | Baris daftar dengan cover kecil. |
| `<x-game.tooltip>` | `game` | Isi tooltip saat kursor di atas kartu. Sudah dipasang di `card`, `capsule`, `tag-card`, `list-row`. Kartu baru perlu atribut `data-game-tip` dan komponen ini di dalamnya. |
| `<x-review.summary>` | `average`, `count`, `breakdown` | Ringkasan rating: angka rata-rata, bintang, jumlah, dan sebaran 5 sampai 1 bintang. |
| `<x-review.star-input>` | `name`, `selected` | Pilihan bintang 1 sampai 5 untuk formulir (tanpa JS). |

Komponen `checkout/*` masih kosong. Maul mengisinya (lihat `05-PEMBAGIAN-TIM.md`).

## 3. Warna

Semua warna datang dari `css/theme.css`. Pakai nama ini.

| Kelas | Dipakai untuk |
|---|---|
| `bg-base` | latar halaman |
| `bg-deep` | latar paling gelap: header, input, kotak kode |
| `bg-panel`, `bg-panel-2` | kaca transparan: kotak dan kartu, hover |
| `text-fg` | teks utama |
| `text-muted`, `text-soft` | teks pendukung, teks paling redup |
| `border-line`, `border-line-teal` | garis tipis, garis teal untuk hover dan fokus |
| `bg-accent`, `text-accent-soft` | merah: tombol utama, diskon, error |
| `bg-accent-2`, `text-accent-2` | teal: tautan, label, menu aktif, fokus |
| `text-star` | bintang ulasan dan status menunggu |

Tombol utama memakai teks krem di atas merah dengan huruf tebal. Kontrasnya sekitar 3,5:1, jadi jangan dipakai untuk teks kecil dan panjang. Pakai `<x-ui.button>` yang sudah mengatur ini.

## 4. Ukuran, sudut, dan jarak

| Hal | Pakai |
|---|---|
| Judul halaman | `<h1 class="text-2xl font-black">` |
| Judul section | `<x-ui.section-title>` (jaraknya sudah diatur) |
| Jarak antar kartu | `gap-3` sampai `gap-5` |
| Isi panel | `p-5` (sudah ada di `<x-ui.panel>`) |
| Sudut kartu dan panel | `rounded-md` (16px) |
| Sudut tombol dan input | `rounded-sm` (10px) |
| Sudut banner besar | `rounded-lg` (22px) |
| Menu, chip, label | `rounded-full` |
| Bayangan kartu | `shadow-elev` |
| Garis | `border border-line` |
| Lebar konten | sudah diatur layout (maksimum 1240px). Jangan atur lagi. |

## 5. Responsif

- Tulis untuk HP dulu, lalu tambah `md:` (768px) dan `lg:` (1024px).
- Grid kartu: `grid-cols-2 md:grid-cols-3 lg:grid-cols-4`.
- Baris yang panjang: `<x-ui.horizontal-row>`.
- Tabel: bungkus dengan `overflow-x-auto`.
- Form: input selebar kolom, sudah diatur `<x-form.input>`.

## 6. Yang tidak boleh

| Dilarang | Gantinya |
|---|---|
| Warna, gradasi, atau bayangan baru yang tidak ada di tema | token tema (`bg-accent`, `shadow-elev`, `shadow-glow-red`, `shadow-glow-teal`) |
| Kode warna langsung (`#fff`, `bg-red-500`) | kelas dari tabel warna |
| `style="..."` | kelas Tailwind (kecuali `--ph-h` milik placeholder) |
| `<script>` di dalam Blade | modul di `js/modules/` dan atribut `data-js` |
| Menulis ulang tombol, kartu, atau panel | komponen yang ada |
| Teks "Lorem" panjang di tampilan | teks singkat yang jelas |

## 7. Memakai template Tailwind dari internet

1. Ambil strukturnya saja (HTML). Salin ke file Blade milikmu.
2. Ganti warna bawaan template ke tema:

| Template | Tema |
|---|---|
| `bg-white`, `bg-gray-50` | `bg-panel` |
| `bg-gray-900`, `bg-black` | `bg-base` atau `bg-deep` |
| `text-gray-900`, `text-white` | `text-fg` |
| `text-gray-500` | `text-muted` atau `text-soft` |
| `border-gray-200` | `border-line` |
| `bg-blue-600`, `bg-indigo-600` | `<x-ui.button>` (primary) |
| `text-blue-600` | `text-accent-2` |
| `rounded-lg`, `rounded-xl` | `rounded-md` |
| `shadow-md`, `shadow-lg` | `shadow-elev` |

3. Ganti tombol, kartu, input, dan panel milik template dengan komponen dari katalog.
4. Hapus gradasi dan bayangan bawaan template, lalu pakai token tema.
5. Tes di HP.

Library komponen seperti DaisyUI dan Flowbite belum terpasang. Jangan memasangnya sendiri. Kalau kamu butuh, bicarakan di grup, karena library itu membawa warna dan gaya sendiri yang bisa merusak keseragaman.

## 8. Checklist sebelum PR

- [ ] Tampil benar di desktop dan HP (390px).
- [ ] Tidak ada kode warna langsung, dan tidak ada gradasi atau bayangan di luar token tema.
- [ ] Semua tombol, kartu, panel, dan input memakai komponen.
- [ ] Tidak ada `<script>` atau `style=""` di Blade.
- [ ] Form memakai `@csrf` dan nama field sesuai `04-DATA-CONTRACT.md`.
- [ ] Variabel yang dipakai sudah tertulis di `04-DATA-CONTRACT.md`.
- [ ] `<x-ui.todo>` sudah dihapus dari file yang selesai.
- [ ] File di luar folder milikmu tidak ikut berubah (cek `git status` sebelum commit).

## 9. Data contoh

Route preview memberi data contoh ke tiap halaman. Objek game dibuat oleh `pv_game($i)` di `routes/preview-data.php`. Kalau butuh data yang belum ada, tambahkan di file itu (berkas bersama: `git pull` dulu dan kabari grup).
