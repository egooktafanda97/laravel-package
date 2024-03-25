<?php

namespace TaliumBlueprint\Handler\LogixHandler;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Touhidurabir\StubGenerator\Facades\StubGenerator;

class Services
{
    private $config = [];

    public function __construct(public $data)
    {
        $this->config = Config::get("blueprint")['blueprint'];
    }

    public function stubBuild()
    {
        $pathStub = __DIR__ . "/../../blueprint/DataTransferObject.stub";

    }
}
