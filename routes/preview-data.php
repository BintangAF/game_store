<?php

/*
  Data contoh untuk preview (milik frontend).
  Bentuk objek mengikuti ERD, jadi view tidak perlu diubah saat controller memakai model asli.
*/

use Illuminate\Support\Carbon;

if (! function_exists('pv_game')) {
    function pv_game(int $i): object
    {
        $category = fn (int $n) => (object) ['category_id' => $n, 'category_name' => 'Kategori '.$n];

        return (object) [
            'game_id' => $i,
            'game_title' => 'Game '.$i,
            'game_price' => $i % 5 === 0 ? 0 : (($i % 9) + 2) * 45000 + 4999,
            'discount_percent' => $i % 3 === 0 ? 20 + ($i % 4) * 10 : null,
            'game_desc' => 'Deskripsi placeholder untuk Game '.$i.'. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'cover_image_path' => null,
            'release_date' => Carbon::now()->subDays($i * 3)->toDateString(),
            'system_requirements' => "OS: -\nRAM: -\nGPU: -\nPenyimpanan: -",
            'developer_name' => 'Studio '.(($i % 3) + 1),
            'publisher_name' => 'Penerbit '.(($i % 2) + 1),
            'categories' => collect([$category(($i % 6) + 1), $category((($i + 2) % 6) + 1)]),
            'tags' => collect(range(1, 4))->map(fn ($k) => (object) ['tag_id' => $k, 'tag_name' => 'Tag '.((($i + $k) % 8) + 1)]),
            'operatingSystems' => collect([(object) ['os_id' => 1, 'os_name' => 'Windows 10'], (object) ['os_id' => 2, 'os_name' => 'Windows 11']]),
            'images' => collect(range(1, 4))->map(fn ($k) => (object) ['image_path' => null, 'sort_order' => $k]),
            'reviews_avg_star' => null,
            'reviews_count' => 0,
        ];
    }

    function pv_games(int $start, int $count)
    {
        return collect(range($start, $start + $count - 1))->map(fn ($i) => pv_game($i));
    }

    function pv_categories()
    {
        return collect(range(1, 6))->map(fn ($n) => (object) ['category_id' => $n, 'category_name' => 'Kategori '.$n]);
    }

    function pv_os()
    {
        return collect([(object) ['os_id' => 1, 'os_name' => 'Windows 10'], (object) ['os_id' => 2, 'os_name' => 'Windows 11']]);
    }

    function pv_reviews(int $count = 3)
    {
        if ($count < 1) {
            return collect();
        }

        $stars = [5, 4, 5, 3, 4, 5, 2, 4];
        $bodies = [
            'Ulasan singkat.',
            'Ulasan placeholder dengan isi yang lebih panjang, supaya tampilan teks yang membungkus ke beberapa baris bisa dicek.',
            'Ulasan placeholder. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.',
        ];

        return collect(range(1, $count))->map(fn ($k) => (object) [
            'star' => $stars[$k % count($stars)],
            'body' => $bodies[$k % count($bodies)],
            'user' => (object) ['username' => 'user'.$k],
            'created_at' => Carbon::now()->subDays($k * 2),
        ]);
    }

    function pv_cart_items()
    {
        return collect([1, 2])->map(fn ($i) => (object) ['game' => pv_game($i)]);
    }

    function pv_orders()
    {
        return collect([
            (object) ['order_id' => 1001, 'created_at' => Carbon::now()->subDays(10), 'status' => 'paid', 'total_amount' => 650000, 'items' => [(object) ['game' => pv_game(1)]]],
            (object) ['order_id' => 1002, 'created_at' => Carbon::now()->subDays(3), 'status' => 'pending', 'total_amount' => 320000, 'items' => [(object) ['game' => pv_game(2)]]],
        ]);
    }

    function pv_user()
    {
        return (object) ['username' => 'username', 'email' => 'email@contoh.com', 'created_at' => Carbon::now()->subMonths(3)];
    }
}
