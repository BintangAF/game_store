<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Table(key: 'user_id')]
#[Fillable(['username', 'email', 'password', 'role_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasName
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // mengatur user yang bisa mengakses panel admin
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role?->role_name === 'admin';
    }

    // mengatur nama yang ditampilkan di panel admin
    public function getFilamentName(): string
    {
        return $this->username;
    }

    // Relasi One to Many
    public function cart()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }
}
