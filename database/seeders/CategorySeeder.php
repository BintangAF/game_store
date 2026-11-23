<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Action', 'slug' => 'action'],
            ['category_name' => 'Adventure', 'slug' => 'adventure'],
            ['category_name' => 'Puzzle', 'slug' => 'puzzle'],
            ['category_name' => 'Role-playing', 'slug' => 'role-playing'],
            ['category_name' => 'Shooter', 'slug' => 'shooter'],
            ['category_name' => 'Simulation', 'slug' => 'simulation'],
            ['category_name' => 'Strategy', 'slug' => 'strategy'],
            ['category_name' => 'Sports', 'slug' => 'sports'],
        ];

        // DB::table('categories')->insert($categories);

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }
    }
}
