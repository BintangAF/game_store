<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['tag_name' => '2D', 'slug' => '2d'],
            ['tag_name' => '4X', 'slug' => '4x'],
            ['tag_name' => 'Arcade', 'slug' => 'arcade'],
            ['tag_name' => 'Atmospheric', 'slug' => 'atmospheric'],
            ['tag_name' => 'Auto Battler', 'slug' => 'auto-battler'],
            ['tag_name' => 'Base Building', 'slug' => 'base-building'],
            ['tag_name' => "Beat 'em up", 'slug' => 'beat-em-up'],
            ['tag_name' => 'Board Game', 'slug' => 'board-game'],
            ['tag_name' => 'Bullet Hell', 'slug' => 'bullet-hell'],
            ['tag_name' => 'Card Game', 'slug' => 'card-game'],
            ['tag_name' => 'Casual', 'slug' => 'casual'],
            ['tag_name' => 'Dating Sim', 'slug' => 'dating-sim'],
            ['tag_name' => 'FPS', 'slug' => 'fps'],
            ['tag_name' => 'Fighting', 'slug' => 'fighting'],
            ['tag_name' => 'First-Person', 'slug' => 'first-person'],
            ['tag_name' => 'Fishing', 'slug' => 'fishing'],
            ['tag_name' => 'Free Game', 'slug' => 'free-game'],
            ['tag_name' => 'Gore', 'slug' => 'gore'],
            ['tag_name' => 'Gacha', 'slug' => 'gacha'],
            ['tag_name' => 'Hack and Slash', 'slug' => 'hack-and-slash'],
            ['tag_name' => 'Historical', 'slug' => 'historical'],
            ['tag_name' => 'Horror', 'slug' => 'horror'],
            ['tag_name' => 'Indie', 'slug' => 'indie'],
            ['tag_name' => 'Isometric', 'slug' => 'isometric'],
            ['tag_name' => 'JRPG', 'slug' => 'jrpg'],
            ['tag_name' => 'Magic', 'slug' => 'magic'],
            ['tag_name' => 'Management', 'slug' => 'management'],
            ['tag_name' => 'Medieval', 'slug' => 'medieval'],
            ['tag_name' => 'Metroidvania', 'slug' => 'metroivania'],
            ['tag_name' => 'Military', 'slug' => 'military'],
            ['tag_name' => 'Multiplayer', 'slug' => 'multiplayer'],
            ['tag_name' => 'Mystery', 'slug' => 'mystery'],
            ['tag_name' => 'Multiple Endings', 'slug' => 'multiple-endings'],
            ['tag_name' => 'Narrative', 'slug' => 'narrative'],
            ['tag_name' => 'Nature', 'slug' => 'nature'],
            ['tag_name' => 'Ninja', 'slug' => 'ninja'],
            ['tag_name' => 'Open World', 'slug' => 'open-world'],
            ['tag_name' => 'Party Game', 'slug' => 'party-game'],
            ['tag_name' => 'Pixel Graphics', 'slug' => 'pixel-graphics'],
            ['tag_name' => 'Platformer', 'slug' => 'platformer'],
            ['tag_name' => 'Point&Click', 'slug' => 'point-and-click'],
            ['tag_name' => 'Psychological', 'slug' => 'psychological'],
            ['tag_name' => 'Psychological Horror', 'slug' => 'psychological-horror'],
            ['tag_name' => 'RTS', 'slug' => 'rts'],
            ['tag_name' => 'Realistic', 'slug' => 'realistic'],
            ['tag_name' => 'Relaxing', 'slug' => 'relaxing'],
            ['tag_name' => 'Retro', 'slug' => 'retro'],
            ['tag_name' => 'Rhythm', 'slug' => 'rhythm'],
            ['tag_name' => 'Robot', 'slug' => 'robot'],
            ['tag_name' => 'Sandbox', 'slug' => 'sandbox'],
            ['tag_name' => 'Sci-fi', 'slug' => 'sci-fi'],
            ['tag_name' => 'Souls-like', 'slug' => 'souls-like'],
            ['tag_name' => 'Stealth', 'slug' => 'stealth'],
            ['tag_name' => 'Survival', 'slug' => 'survival'],
            ['tag_name' => 'Survival Horror', 'slug' => 'survival-horror'],
            ['tag_name' => 'Third Person', 'slug' => 'third-person'],
            ['tag_name' => 'Turn-Based', 'slug' => 'turn-based'],
            ['tag_name' => 'Violent', 'slug' => 'violent'],
            ['tag_name' => 'Visual Novel', 'slug' => 'visual-novel'],
            ['tag_name' => 'War', 'slug' => 'war'],
            ['tag_name' => 'Zombie', 'slug' => 'zombie'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate($tag);
        };
    }
}
