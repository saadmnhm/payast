<?php

namespace App\Providers;

use Livewire\Livewire;
use App\Core\KTBootstrap;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\FrontendNavigationComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Update defaultStringLength
        Builder::defaultStringLength(191);

        KTBootstrap::init();

        if (app()->environment('production')) {
            Livewire::setUpdateRoute(function ($handle) {
                return Route::post('/starterkit/metronic/laravel/livewire/update', $handle);
            });
        }

        // Share navigation menu with all frontend views
        View::composer(['front.*', 'components.navigation-menu'], FrontendNavigationComposer::class);
    }
}
