<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Game;
use App\Models\GameImage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            OperatingSystemSeeder::class,
            RoleSeeder::class,
            TagSeeder::class,
        ]);

        User::factory(4)->create();

        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'password' => 123,
            'role_id' => 1,
        ]);

        // Akun contoh untuk mencoba toko: demo@mail.com / password
        $demo = User::factory()->create([
            'username' => 'demo',
            'email' => 'demo@mail.com',
            'password' => 'password',
            'role_id' => 2,
        ]);

        Game::factory(24)->create();

        // Gambar galeri tidak diisi: tampilan memakai placeholder bila kosong.

        // Demo punya 3 game dari order "paid" (muncul di Koleksi dan boleh menulis ulasan)
        $owned = Game::inRandomOrder()->take(3)->get();
        $order = Order::create([
            'user_id' => $demo->user_id,
            'total_amount' => $owned->sum('game_price'),
            'status' => 'paid',
            'payment_method' => 'qris',
        ]);
        foreach ($owned as $game) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'game_id' => $game->game_id,
                'price_at_purchase' => $game->game_price,
            ]);
        }

        // Keranjang dan wishlist demo (game yang belum dimiliki)
        $others = Game::whereNotIn('game_id', $owned->pluck('game_id'))->inRandomOrder()->take(4)->get();
        foreach ($others->take(2) as $game) {
            Cart::create(['user_id' => $demo->user_id, 'game_id' => $game->game_id]);
        }
        foreach ($others->slice(2) as $game) {
            Wishlist::create(['user_id' => $demo->user_id, 'game_id' => $game->game_id]);
        }

        // Ulasan dari user lain (unik per user + game)
        $users = User::where('user_id', '!=', $demo->user_id)->get();
        foreach (Game::inRandomOrder()->take(15)->get() as $game) {
            foreach ($users->random(rand(1, min(4, $users->count()))) as $user) {
                Review::create([
                    'user_id' => $user->user_id,
                    'game_id' => $game->game_id,
                    'star' => rand(2, 5),
                    'body' => fake()->realText(120),
                ]);
            }
        }
    }
}
