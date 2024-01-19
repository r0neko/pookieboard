<?php

namespace App\Console\Commands;

use App\PookieBoard\Modules\ModuleManager;
use Illuminate\Console\Command;

class ActivateModuleCommand extends Command
{
    protected $signature = 'module:activate {package}';
    protected $description = 'Enable a PookieBoard module.';

    public function handle(ModuleManager $manager): void
    {
        $packageName = $this->argument("package");

        if(!$manager->hasPackage($packageName)) {
            $this->error("The '{$packageName}' module does not exist!");
            return;
        }

        if($manager->getPackage($packageName)->isActive()) {
            $this->warn("The '{$packageName}' module is already active!");
            return;
        }

        $this->warn("Activating '{$packageName}' ...");
        $manager->activatePackage($manager->getPackage($packageName));
        $this->info("The '{$packageName}' module was activated successfully.");
    }
}
