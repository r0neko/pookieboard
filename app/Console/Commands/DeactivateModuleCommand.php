<?php

namespace App\Console\Commands;

use App\PookieBoard\Modules\ModuleManager;
use Illuminate\Console\Command;

class DeactivateModuleCommand extends Command
{
    protected $signature = 'module:deactivate {package}';
    protected $description = 'Disable a PookieBoard module.';

    public function handle(ModuleManager $manager): void
    {
        $packageName = $this->argument("package");

        if(!$manager->hasPackage($packageName)) {
            $this->error("The '{$packageName}' module does not exist!");
            return;
        }

        if(!$manager->getPackage($packageName)->isActive()) {
            $this->warn("The '{$packageName}' module is already inactive!");
            return;
        }

        $manager->deactivatePackage($manager->getPackage($packageName));
        $this->info("The '{$packageName}' module was disabled successfully.");
    }
}
