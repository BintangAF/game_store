<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table('operating_systems', key: 'os_id')]
#[Fillable(['os_name'])]
#[Guarded(['os_id'])]
class OperatingSystem extends Model
{
    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_os', 'os_id', 'game_id');
    }
}
