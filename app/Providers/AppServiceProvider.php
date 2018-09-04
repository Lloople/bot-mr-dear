<?php

namespace App\Providers;

use App\OhDear\Services\OhDear;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OhDear::class, OhDear::class);

        Carbon::setToStringFormat('D, F d, Y');
    }
}
