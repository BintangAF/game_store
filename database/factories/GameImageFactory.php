<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\GameImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GameImage>
 */
class GameImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_path' => function () {
                $word = fake()->word();
                return "image/$word.png";
            },
            'sort_order' => rand(0, 10),
            'game_id' => Game::inRandomOrder()->value('game_id'),
        ];
    }
}
