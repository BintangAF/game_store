<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Game;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'game_title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(100, 999),
            'game_price' => fake()->randomFloat(2, 15000, 100000),
            'game_desc' => fake()->paragraph(),
            'cover_image_path' => function () {
                $word = fake()->word();
                return "image/$word.png";
            },
            'game_file_path' => function () {
                $word = fake()->word();
                return "game/$word.zip";
            },
            'release_date' => fake()->date(),
            'system_requirements' => fake()->sentence(),
            'developer_name' => fake()->company(),
            'publisher_name' => fake()->company(),
            'is_active' => fake()->boolean(),
        ];
    }

    // Memasukkan data ke tabel pivot game_tag dan game_category
    // setelah selesai membuat data game
    public function configure()
    {
        return $this->afterCreating(function (Game $game) {
            // Mengambil 1 sampai 3 Tag secara acak dan memasukkannya ke tabel game_tag
            $game->tags()->attach(
                Tag::inRandomOrder()->limit(rand(1, 3))->pluck('tag_id')
            );

            // Mengambil 1 sampai 2 Category secara acak dan memasukkannya ke tabel game_category
            $game->categories()->attach(
                Category::inRandomOrder()->limit(rand(1, 2))->pluck('category_id')
            );
        });
    }
}
