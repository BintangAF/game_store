<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Table(key: 'order_id')]
#[Fillable(['user_id', 'total_amount', 'status', 'payment_method'])]
#[Guarded(['order_id'])]
class Order extends Model
{
    use HasFactory;

    protected function casts()
    {
        return ['total_amount' => 'decimal:2'];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
