<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table('order_items')]
#[Fillable(['order_id', 'game_id', 'price_at_purchase'])]
#[Guarded(['id'])]
class OrderItem extends Model
{
    protected function casts()
    {
        return ['price_at_purchase' => 'decimal:2'];
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id') ;
    }
}
