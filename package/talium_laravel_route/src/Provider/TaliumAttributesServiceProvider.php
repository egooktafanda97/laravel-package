<?php

namespace TaliumAttributes\Provider;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use TaliumAttributes\Collection\Handler\RouterHandler;

class TaliumAttributesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            RouterHandler::route();
        });
    }
}
