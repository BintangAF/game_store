<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'star' => rand(1, 5),
            'body' => fake()->realText(),
            'user_id' => User::inRandomOrder()->value('user_id'),
            'game_id' => Game::inRandomOrder()->value('game_id'),
        ];
    }
}
