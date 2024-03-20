<?php

namespace TaliumBlueprint\Handler;

use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;
use TaliumBlueprint\Traits\FileSystem;
use TaliumBlueprint\Traits\HelperBlueprint;

class BladeComponentHandler
{
    use FileSystem;
    use HelperBlueprint;

    public function __construct(public $filesName)
    {
    }

    public function main()
    {


        $blueprint = $this->blueprint_config()["blueprint"]["blueprint_path"] . $this->filesName;
        $thisBlueprint = Yaml::parseFile($blueprint);
        foreach ($thisBlueprint as $enpoint => $blueprints) {
            $enpoint = $this->expoint($enpoint);
            dd($enpoint);
        }
        // $this->loadBlueprint();
    }

    public function loadBlueprint($files)
    {
    }
}
