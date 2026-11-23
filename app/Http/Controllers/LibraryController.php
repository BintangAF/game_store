<?php

namespace App\Http\Controllers;

class LibraryController extends Controller
{
    public static function libraryFor(int $userId)
    {
        return HomeController::storeGames()
            ->whereHas('orderItems', fn ($q) => $q->whereHas('order',
                fn ($o) => $o->where('user_id', $userId)->where('status', 'paid')))
            ->get();
    }

    public function index()
    {
        return view('collection.index', ['library' => static::libraryFor(auth()->user()->user_id)]);
    }
}
