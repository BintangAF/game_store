<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('user_id'),
            'game_id' => Game::inRandomOrder()->value('game_id'),
        ];
    }
}
