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

        Game::factory(10)->create();
        GameImage::factory(15)->create();
        Wishlist::factory(5)->create();
        Cart::factory(5)->create();
        Order::factory(3)->create();
        OrderItem::factory(5)->create();
        Review::factory(8)->create();
    }
}
