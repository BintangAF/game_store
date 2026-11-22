<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table(key: 'role_id')]
#[Fillable(['role_name'])]
#[Guarded(['role_id'])]
class Role extends Model
{
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
