<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Repositories\Contracts\NewsRepositoryInterface;
use App\Repositories\KonaweNewsRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NewsRepositoryInterface::class, KonaweNewsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production' || request()->header('x-forwarded-proto') !== 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        View::composer('*', function ($view): void {
            $siteSetting = SiteSetting::current();

            $view->with('siteSetting', $siteSetting);
            $view->with('registrationSetting', $siteSetting);
        });
    }
}
