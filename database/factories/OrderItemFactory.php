<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::inRandomOrder()->value('order_id'),
            'game_id' => Game::inRandomOrder()->value('game_id'),
            'price_at_purchase' => fake()->randomFloat(2, 30000, 300000),
        ];
    }
}
