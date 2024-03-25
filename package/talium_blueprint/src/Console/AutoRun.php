<?php

namespace TaliumBlueprint\Console;

use Illuminate\Support\Facades\Artisan;

class AutoRun
{
    public function __construct()
    {

    }

    public function repositoryServices($class)
    {
        if (!is_dir(app_path("Repositories/" . $class))) {
            mkdir(app_path("Repositories/" . $class), 0755, true);
        }
        if (!is_dir(app_path("Services/" . $class))) {
            mkdir(app_path("Services/" . $class), 0755, true);
        }
        Artisan::call('make:repository', ['name' => $class . "Repository" ]);
        Artisan::call('make:service', ['name' => $class . "Service"]);
    }
}
