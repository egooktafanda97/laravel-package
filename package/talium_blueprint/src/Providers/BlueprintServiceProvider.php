<?php

namespace TaliumBlueprint\Providers;

use Illuminate\Support\ServiceProvider;
use TaliumBlueprint\Console\Commands\Blueprint;
use TaliumBlueprint\Console\Commands\PublishConfigCommand;

class BlueprintServiceProvider extends ServiceProvider
{
    public function boot()
    {
        # php artisan vendor:publish --provider="talium_blueprint/laravel"
        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishConfigCommand::class,
                Blueprint::class,
            ]);
            # --tag="config"
            $this->publishes([
                __DIR__ . '/../Config/config.php' => config_path('blueprint.php'),
            ], 'config');

            # --tag="view-components"
            $this->publishes([
                __DIR__ . '/../UI/Components/' => resource_path('views/components/'),
                __DIR__ . '/../UI/Assets/' => public_path(),
            ], 'template-blueprint');

            # --tag="view-components-default"
            $this->publishes([
                base_path('"blueprint/UI/templalte/Components/') => resource_path('views/components/'),
                base_path("blueprint/UI/templalte/Assets/") => public_path(),
            ], 'template-default');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'blueprint');
    }
}
