<?php

namespace TaliumBlueprint\Console\Commands;

use Illuminate\Console\Command;

class PublishConfigCommand extends Command
{
    protected $signature = 'blueprint:publish-config';

    protected $description = 'Publish config from external package';

    public function handle()
    {
        $this->call('vendor:publish', [
            '--provider' => 'WendellAdriel\ValidatedDTO\Providers\ValidatedDTOServiceProvider',
            '--tag' => 'config',
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'LaravelEasyRepository\LaravelEasyRepositoryServiceProvider',
            '--tag' => 'easy-repository-config',
        ]);
    }
}
