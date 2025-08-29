<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeFeatureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:feature {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create classes for a new feature';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $featureName = $this->argument('name');
        $nameDividedBySlash = explode('/', $featureName);
        $pureFeatureName = end($nameDividedBySlash);
        $this->call('make:request', ['name' => "{$featureName}Request"]);
        $this->call('make:action', ['name' => "{$featureName}Action", '--request' => "{$pureFeatureName}Request"]);
        $this->call('make:test', ['name' => "{$featureName}Test"]);

        return false;
    }
}
