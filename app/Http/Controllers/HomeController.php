<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Game;

class HomeController extends Controller
{
    /** Query dasar game toko: aktif + rating + jumlah ulasan + relasi untuk kartu. */
    public static function storeGames()
    {
        return Game::active()
            ->with(['categories', 'tags'])
            ->withAvg('reviews', 'star')
            ->withCount('reviews');
    }

    public function index()
    {
        $user = auth()->user();
        $ownedIds = $user ? $this->ownedGameIds($user->user_id) : collect();

        // 5 game unggulan: rilis terbaru yang sudah rilis
        $featured = static::storeGames()->where('release_date', '<=', now())
            ->latest('release_date')->take(5)->get();

        $newReleases = static::storeGames()->where('release_date', '<=', now())
            ->latest('release_date')->take(4)->get();

        $underPrice = static::storeGames()->where('game_price', '<=', 90000)
            ->orderBy('game_price')->take(5)->get();

        // Rekomendasi: game yang kategorinya sama dengan yang dimiliki (hanya bila login & punya game)
        $recommendedByLibrary = collect();
        $becauseOf = null;
        $becauseOfGames = collect();

        if ($ownedIds->isNotEmpty()) {
            $categoryIds = Category::whereHas('games', fn ($q) => $q->whereIn('games.game_id', $ownedIds))
                ->pluck('category_id');

            $recommendedByLibrary = static::storeGames()
                ->whereNotIn('game_id', $ownedIds)
                ->whereHas('categories', fn ($q) => $q->whereIn('categories.category_id', $categoryIds))
                ->inRandomOrder()->take(5)->get();

            // "Karena kamu memiliki X": 1 game dimiliki + 4 game dengan tag serupa
            $becauseOf = Game::with('tags')->whereIn('game_id', $ownedIds)->inRandomOrder()->first();
            if ($becauseOf) {
                $becauseOfGames = static::storeGames()
                    ->whereNotIn('game_id', $ownedIds)
                    ->whereHas('tags', fn ($q) => $q->whereIn('tags.tag_id', $becauseOf->tags->pluck('tag_id')))
                    ->inRandomOrder()->take(4)->get();
            }
        }

        // 2 blok kategori (masing-masing 4 game)
        $tagBlocks = Category::whereHas('games')->inRandomOrder()->take(2)->get()
            ->map(fn ($c) => (object) [
                'id' => $c->category_id,
                'name' => $c->category_name,
                'games' => static::storeGames()
                    ->whereHas('categories', fn ($q) => $q->where('categories.category_id', $c->category_id))
                    ->take(4)->get(),
            ]);

        $bestsellers = static::storeGames()
            ->withCount(['orderItems as sold_count' => fn ($q) => $q->whereHas('order', fn ($o) => $o->where('status', 'paid'))])
            ->orderByDesc('sold_count')->orderByDesc('reviews_count')->take(8)->get();

        $upcoming = static::storeGames()->where('release_date', '>', now())
            ->orderBy('release_date')->take(8)->get();
        if ($upcoming->count() < 8) {
            $upcoming = $upcoming->concat(
                static::storeGames()->whereNotIn('game_id', $upcoming->pluck('game_id'))
                    ->orderByDesc('reviews_count')->take(8 - $upcoming->count())->get()
            );
        }

        return view('home.index', [
            'featured' => $featured,
            'categories' => Category::all(),
            'recommendedByLibrary' => $recommendedByLibrary,
            'becauseOf' => $becauseOf,
            'becauseOfGames' => $becauseOfGames,
            'tagBlocks' => $tagBlocks,
            'newReleases' => $newReleases,
            'tabs' => [
                'newest' => ['label' => 'Rilisan terbaru', 'games' => static::storeGames()->where('release_date', '<=', now())->latest('release_date')->take(8)->get()],
                'bestsellers' => ['label' => 'Terlaris', 'games' => $bestsellers],
                'upcoming' => ['label' => 'Populer dan mendatang', 'games' => $upcoming],
            ],
            'underPrice' => $underPrice,
        ]);
    }

    private function ownedGameIds(int $userId)
    {
        return \App\Models\OrderItem::whereHas('order', fn ($q) => $q->where('user_id', $userId)->where('status', 'paid'))
            ->pluck('game_id')->unique()->values();
    }
}
