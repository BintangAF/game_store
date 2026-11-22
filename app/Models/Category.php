<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table(key: 'category_id')]
#[Fillable(['category_name'])]
#[Guarded(['category_id'])]
class Category extends Model
{
    // Relasi Many to Many
    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_category', 'category_id', 'game_id');
    }
}
