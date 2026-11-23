<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Table(key: 'game_id')]
#[Fillable([
    'game_title', 'game_price', 'game_desc', 'cover_image_path',
    'game_file_path', 'release_date', 'system_requirements', 'developer_name',
    'publisher_name', 'is_active', 'slug',
])]
#[Guarded(['game_id'])]
class Game extends Model
{
    use HasFactory;

    // Slug dibuat otomatis dari judul bila belum diisi (kolom slug NOT NULL + unique)
    protected static function booted(): void
    {
        static::creating(function (Game $game) {
            if (empty($game->slug)) {
                $game->slug = \Illuminate\Support\Str::slug($game->game_title).'-'.\Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(6));
            }
        });
    }

    // Hanya game yang aktif tampil di toko
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

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
        return $this->hasMany(Cart::class, 'game_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'game_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'game_id');
    }

    public function gameImages()
    {
        return $this->hasMany(GameImage::class, 'game_id')->orderBy('sort_order');
    }

    // Nama yang dipakai di kontrak data frontend ($game->images)
    public function images()
    {
        return $this->hasMany(GameImage::class, 'game_id')->orderBy('sort_order');
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
