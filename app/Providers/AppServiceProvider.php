<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Support\HeaderNotices;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventSilentlyDiscardingAttributes($this->app->isLocal());

        // Variabel global untuk semua halaman (lihat docs/04-DATA-CONTRACT.md bagian 2)
        View::composer('*', function ($view) {
            // Dihitung sekali per request, bukan per partial/komponen
            $attrs = request()->attributes;
            if (! $attrs->has('shared_view_data')) {
                $attrs->set('shared_view_data', [
                    'cartCount' => auth()->check() ? auth()->user()->cart()->count() : 0,
                    'navCategories' => Category::orderBy('category_name')->get(),
                    'headerNotices' => HeaderNotices::get(),
                ]);
            }

            $view->with($attrs->get('shared_view_data'));
        });
    }
}
