<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

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

    /**
     * The "booted" method of the model.
     * Dijalankan otomatis saat Model di-load
     */
    protected static function booted(): void
    {
        // Event saat data BARU akan dibuat (Creating)
        static::creating(function (Game $game) {
            if (empty($game->slug)) {
                $game->slug = static::createUniqueSlug($game->game_title);
            }
        });

        // Event saat data akan di-UPDATE
        static::updating(function (Game $game) {
            // Hanya generate ulang slug jika judul game berubah
            if ($game->isDirty('game_title')) {
                $game->slug = static::createUniqueSlug($game->game_title, $game->game_id);
            }
        });
    }

    /**
     * Helper untuk membuat slug yang unik
     */
    private static function createUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        // Cek apakah slug sudah ada di database
        while (
            static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('game_id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
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
