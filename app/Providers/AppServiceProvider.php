<?php

namespace App\Providers;

use App\Domain\Content\Contracts\NewsGateway;
use App\Infrastructure\Konawe\KonaweNewsApi;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NewsGateway::class, KonaweNewsApi::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
