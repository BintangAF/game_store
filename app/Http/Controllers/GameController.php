<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\OrderItem;
use App\Models\Review;

class GameController extends Controller
{
    public function show($id)
    {
        $game = HomeController::storeGames()->with(['operatingSystems', 'images'])->findOrFail($id);
        $user = auth()->user();

        $owned = $user ? $this->userOwns($user->user_id, $game->game_id) : false;
        $inCart = $user ? $user->cart()->where('game_id', $game->game_id)->exists() : false;
        $wishlisted = $user ? $user->wishlist()->where('game_id', $game->game_id)->exists() : false;

        // Hasil agregat per bintang: [5 => n, 4 => n, ..., 1 => n]
        $counts = $game->reviews()->selectRaw('star, count(*) as total')->groupBy('star')->pluck('total', 'star');
        $ratingBreakdown = collect([5, 4, 3, 2, 1])->mapWithKeys(fn ($s) => [$s => (int) ($counts[$s] ?? 0)])->all();

        // guest | must_buy | allowed | reviewed
        $reviewAccess = match (true) {
            ! $user => 'guest',
            Review::where('user_id', $user->user_id)->where('game_id', $game->game_id)->exists() => 'reviewed',
            ! $owned => 'must_buy',
            default => 'allowed',
        };

        $categoryIds = $game->categories->pluck('category_id');
        $similarGames = HomeController::storeGames()
            ->where('game_id', '!=', $game->game_id)
            ->whereHas('categories', fn ($q) => $q->whereIn('categories.category_id', $categoryIds))
            ->inRandomOrder()->take(4)->get();

        return view('games.show', [
            'game' => $game,
            'reviews' => $game->reviews()->with('user')->latest()->paginate(5, ['*'], 'ulasan')->fragment('ulasan'),
            'ratingBreakdown' => $ratingBreakdown,
            'reviewAccess' => $reviewAccess,
            'owned' => $owned,
            'inCart' => $inCart,
            'wishlisted' => $wishlisted,
            'similarGames' => $similarGames,
        ]);
    }

    public static function userOwns(int $userId, int $gameId): bool
    {
        return OrderItem::where('game_id', $gameId)
            ->whereHas('order', fn ($q) => $q->where('user_id', $userId)->where('status', 'paid'))
            ->exists();
    }
}
