<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->user_id;

        return view('wishlist.index', [
            'wishlist' => HomeController::storeGames()
                ->whereHas('wishlists', fn ($q) => $q->where('user_id', $userId))->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['game_id' => ['required', 'exists:games,game_id']]);

        Wishlist::firstOrCreate(['user_id' => auth()->user()->user_id, 'game_id' => $data['game_id']]);

        return back()->with('status', 'Ditambahkan ke wishlist.');
    }

    public function destroy(Game $game)
    {
        auth()->user()->wishlist()->where('game_id', $game->game_id)->delete();

        return back()->with('status', 'Dihapus dari wishlist.');
    }
}
