<?php

namespace App\Providers;

use App\Models\Service;
use App\Settings\GeneralSettings;
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
        View::composer('components.layout', function ($view) {
            $view->with('settings', app(GeneralSettings::class));
            $view->with('navServices', Service::query()->active()->ordered()->get());
        });

        View::composer('components.landing-layout', function ($view) {
            $view->with('settings', app(GeneralSettings::class));
        });
    }
}
