<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table('game_images')]
#[Fillable(['game_id', 'image_path', 'sort_order'])]
#[Guarded(['id'])]
class GameImage extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
