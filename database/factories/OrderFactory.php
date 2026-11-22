<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total_amount' => fake()->randomFloat(2, 20000, 200000),
            'status' => fake()->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'payment_method' => fake()->creditCardType(),
            'user_id' => User::inRandomOrder()->value('user_id'),
        ];
    }
}
