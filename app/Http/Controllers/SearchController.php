<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OperatingSystem;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['q', 'category', 'os', 'max_price', 'sort']);
        $q = trim((string) $request->query('q', ''));

        $games = HomeController::storeGames()
            ->when($q !== '', fn ($query) => $query->where(function ($w) use ($q) {
                $w->where('game_title', 'like', "%{$q}%")
                    ->orWhere('developer_name', 'like', "%{$q}%")
                    ->orWhere('game_desc', 'like', "%{$q}%");
            }))
            ->when($request->filled('category'), fn ($query) => $query->whereHas('categories',
                fn ($c) => $c->where('categories.category_id', $request->query('category'))))
            ->when($request->filled('os'), fn ($query) => $query->whereHas('operatingSystems',
                fn ($o) => $o->where('operating_systems.os_id', $request->query('os'))))
            ->when($request->filled('max_price'), fn ($query) => $query->where('game_price', '<=', (float) $request->query('max_price')));

        match ($request->query('sort')) {
            'newest' => $games->latest('release_date'),
            'cheapest' => $games->orderBy('game_price'),
            'popular' => $games->orderByDesc('reviews_count'),
            'bestseller' => $games->withCount(['orderItems as sold_count' => fn ($q) => $q->whereHas('order', fn ($o) => $o->where('status', 'paid'))])
                ->orderByDesc('sold_count'),
            // relevant: judul yang cocok di atas
            default => $q !== ''
                ? $games->orderByRaw('CASE WHEN game_title LIKE ? THEN 0 ELSE 1 END', ["%{$q}%"])->orderBy('game_title')
                : $games->orderBy('game_title'),
        };

        return view('search.index', [
            'games' => $games->paginate(9)->withQueryString(),
            'query' => $q ?: null,
            'filters' => $filters,
            'categories' => Category::orderBy('category_name')->get(),
            'operatingSystems' => OperatingSystem::orderBy('os_name')->get(),
        ]);
    }
}
