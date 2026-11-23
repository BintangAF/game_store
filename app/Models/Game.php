<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Table(key: 'game_id')]
#[Fillable([
    'game_title', 'slug', 'game_price', 'game_desc', 'cover_image_path',
    'game_file_path', 'release_date', 'system_requirements', 'developer_name',
    'publisher_name', 'is_active',
])]
#[Guarded(['game_id'])]
class Game extends Model
{
    use HasFactory;

    protected function casts()
    {
        return [
            'game_price' => 'decimal:2',
            'release_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    // Relasi One to Many
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function gameImages()
    {
        return $this->hasMany(GameImage::class)->orderBy('sort_order');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'game_id');
    }

    // Relasi Many to Many
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'game_category', 'game_id', 'category_id');
    }

    public function operatingSystems()
    {
        return $this->belongsToMany(OperatingSystem::class, 'game_os', 'game_id', 'os_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'game_tag', 'game_id', 'tag_id');
    }
}
