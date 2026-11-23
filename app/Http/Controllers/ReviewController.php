<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'game_id' => ['required', 'exists:games,game_id'],
            'star' => ['required', 'integer', 'between:1,5'],
            'body' => ['nullable', 'string', 'max:2000'],
        ]);
        $user = auth()->user();

        // Aturan ada di backend: hanya pembeli (order paid), satu ulasan per game
        abort_unless(GameController::userOwns($user->user_id, $data['game_id']), 403, 'Beli game ini dulu untuk menulis ulasan.');

        if (Review::where('user_id', $user->user_id)->where('game_id', $data['game_id'])->exists()) {
            return back()->with('status', 'Kamu sudah menulis ulasan untuk game ini.');
        }

        Review::create([
            'user_id' => $user->user_id,
            'game_id' => $data['game_id'],
            'star' => $data['star'],
            'body' => $data['body'] ?? null,
        ]);

        return back()->with('status', 'Terima kasih, ulasanmu tersimpan.');
    }
}
