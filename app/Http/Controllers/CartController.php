<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Game;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = auth()->user()->cart()->with('game.categories')->latest()->get();

        return view('cart.index', [
            'items' => $items,
            'total' => static::total($items),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['game_id' => ['required', 'exists:games,game_id']]);
        $user = auth()->user();

        if (GameController::userOwns($user->user_id, $data['game_id'])) {
            return back()->with('status', 'Kamu sudah memiliki game ini.');
        }

        Cart::firstOrCreate(['user_id' => $user->user_id, 'game_id' => $data['game_id']]);

        return back()->with('status', 'Ditambahkan ke keranjang.');
    }

    public function destroy(Game $game)
    {
        auth()->user()->cart()->where('game_id', $game->game_id)->delete();

        return back()->with('status', 'Dihapus dari keranjang.');
    }

    /** Total rupiah. Bila nanti ada discount_percent, hitung di sini. */
    public static function total($items): float
    {
        return (float) $items->sum(function ($item) {
            $price = (float) $item->game->game_price;
            $discount = $item->game->discount_percent ?? null;

            return $discount ? $price * (100 - $discount) / 100 : $price;
        });
    }
}
