<?php

namespace App\Providers;

use App\Managers\SiteManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class SiteProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('sitemanager', function () {
            return new SiteManager();
        });
    }
}
