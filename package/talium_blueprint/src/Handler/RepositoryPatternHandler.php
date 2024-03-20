<?php

namespace TaliumBlueprint\Handler;

use TaliumBlueprint\Traits\FileSystem;

class RepositoryPatternHandler
{
    use FileSystem;

    public function __construct()
    {
    }

    public function handle()
    {
        $this->dir_path('/../../Console/Commands/PublishConfigCommand.php');
    }
}
