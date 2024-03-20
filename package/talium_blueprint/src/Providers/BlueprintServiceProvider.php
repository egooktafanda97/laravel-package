<?php

namespace TaliumBlueprint\Providers;

use Illuminate\Support\ServiceProvider;
use TaliumBlueprint\Console\Commands\Blueprint;
use TaliumBlueprint\Console\Commands\PublishConfigCommand;

class BlueprintServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishConfigCommand::class,
                Blueprint::class,
            ]);
            $this->publishes([
                __DIR__ . '/../Config/config.php' => config_path('blueprint.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'blueprint');
    }
}
