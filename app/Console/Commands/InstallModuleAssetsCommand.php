<?php

namespace App\Console\Commands;

use App\PookieBoard\Modules\ModuleManager;
use Illuminate\Console\Command;

class InstallModuleAssetsCommand extends Command
{
    protected $signature = 'module:assets {package}';
    protected $description = 'Install assets of a specific package.';

    public function handle(ModuleManager $manager): void
    {
        $packageName = $this->argument("package");

        if(!$manager->hasPackage($packageName)) {
            $this->error("The '{$packageName}' module does not exist!");
            return;
        }

        if(!$manager->getPackage($packageName)->isActive()) {
            $this->warn("The '{$packageName}' module is not active!");
            return;
        }

        $this->warn("Installing assets from '{$packageName}' ...");
        $manager->installAssets($manager->getPackage($packageName));
        $this->info("The assets from the '{$packageName}' module were installed successfully.");
    }
}
