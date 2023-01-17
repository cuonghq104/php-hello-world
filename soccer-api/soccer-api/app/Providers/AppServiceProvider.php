<?php

namespace App\Providers;

use App\Data\Repositories\EventRepositoryInterface;
use App\Data\Repositories\GameMatchRepositoryInterface;
use App\Data\Repositories\PlayerMatchRepositoryInterface;
use App\Data\Repositories\PlayerRepositoryInterface;
use App\Data\Repositories\TeamMatchRepositoryInterface;
use App\Models\Event;
use App\Models\GameMatch;
use App\Observers\EventObserver;
use App\Observers\GameMatchObserver;
use App\Repositories\EventRepository;
use App\Repositories\GameMatchRepository;
use App\Repositories\PlayerMatchRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\TeamMatchRepository;
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
        $this->app->singleton(
            EventRepositoryInterface::class,
            EventRepository::class
        );
        $this->app->singleton(
            TeamMatchRepositoryInterface::class,
            TeamMatchRepository::class
        );
        $this->app->singleton(
            PlayerRepositoryInterface::class,
            PlayerRepository::class
        );
        $this->app->singleton(
            PlayerMatchRepositoryInterface::class,
            PlayerMatchRepository::class
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
        Event::observe(EventObserver::class);
    }
}
