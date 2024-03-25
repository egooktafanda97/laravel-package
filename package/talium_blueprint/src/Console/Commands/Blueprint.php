<?php

namespace TaliumBlueprint\Console\Commands;

use Illuminate\Console\Command;
use TaliumBlueprint\Handler\BladeComponentHandler;

class Blueprint extends Command
{
    protected $signature = 'blueprint:crete {name} {--blueprint}';

    protected $description = 'create a new blueprint file';

    public function handle()
    {
        try {
            $blueprint = new BladeComponentHandler($this->argument('name') . ".yaml");
            $blueprint->main()->dump()->publish();
            $this->info('blueprint:crete command ' . $this->argument('name') . ' is running');
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
