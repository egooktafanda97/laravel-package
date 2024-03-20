<?php

namespace TaliumBlueprint\Traits;

trait FileSystem
{
    public function dir_path($path)
    {
        return __DIR__ . $path;
    }

    public function blueprint_config($conf = null)
    {
        return config("blueprint" . $conf);
    }
}
