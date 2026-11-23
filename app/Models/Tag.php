<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table(key: 'tag_id')]
#[Fillable(['tag_name', 'slug'])]
#[Guarded(['tag_id'])]
class Tag extends Model
{
    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_tag', 'tag_id', 'game_id');
    }
}
