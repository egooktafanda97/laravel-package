<?php

namespace TaliumBlueprint\Console\Commands;

use Illuminate\Console\Command;

class Blueprint extends Command
{
    protected $signature = 'blueprint:crete {name} {--blueprint}';

    protected $description = 'create a new blueprint file';

    public function handle()
    {
        $this->info('blueprint:crete command called');
    }
}
