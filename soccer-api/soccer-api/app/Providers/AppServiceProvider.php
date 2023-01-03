<?php

namespace App\Providers;

use App\Data\Repositories\GameMatchRepositoryInterface;
use App\Models\GameMatch;
use App\Observers\GameMatchObserver;
use App\Repositories\GameMatchRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
        $this->app->singleton(
            GameMatchRepositoryInterface::class,
            GameMatchRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        GameMatch::observe(GameMatchObserver::class);
    }
}
