<?php

namespace App\PookieBoard\Modules;

use Exception;
use FilesystemIterator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use function Illuminate\Filesystem\join_paths;

class ModuleManager
{
    protected $loadedModules = [];
    protected $modulesDBList = [];
    protected $modulesSeeders = [];

    public const POOKIEBOARD_MODULE_TYPE = 'pookieboard-module';
    public const POOKIEBOARD_CORE_TYPE = 'pookieboard-core';
    private const POOKIEBOARD_CMS_MODULE_NAME = "PookieBoardCMS";

    public function loadPackages()
    {
        // make sure the pb_modules list exist beforehand
        if (DB::table("pb_modules")->exists()) {
            $this->modulesDBList = DB::table("pb_modules")->get()->all();
        }

        // the CMS module is a CORE plugin!
        $this->modulesDBList[] = (object) [
            "name" => self::POOKIEBOARD_CMS_MODULE_NAME,
            "active" => true
        ];

        $modulesPath = base_path('modules');
        $modules = File::directories($modulesPath);

        foreach ($modules as $modulePath) {
            $this->loadPackage($modulePath);
        }
    }

    public function registerPackages()
    {
        foreach ($this->loadedModules as $module) {
            if ($module->isActive()) {
                $this->registerPackage($module);
            }
        }
    }

    protected function getServiceProviders(ModulePackage $package)
    {
        $servicesFile = $package->getRelativePackagePath("/src/Module/services.php");

        if (File::exists($servicesFile)) {
            return include $servicesFile;
        }

        return [];
    }

    protected function getSeeders(ModulePackage $package)
    {
        $seedersFile = $package->getRelativePackagePath("/src/Module/seeders.php");

        if (File::exists($seedersFile)) {
            return include $seedersFile;
        }

        return [];
    }

    public function registerPackage(ModulePackage $package)
    {
        if (!$package->isActive()) return;

        $package->getAutoloader()->register();

        // register service providers
        $serviceProviders = $this->getServiceProviders($package);

        foreach ($serviceProviders as $serviceProvider) {
            App::register($serviceProvider);
        }

        // get master namespace
        $psrPrefixes = $package->getAutoloader()->getPrefixesPsr4();
        $masterNamespace = array_key_first($psrPrefixes);

        $routesFile = $package->getRelativePackagePath("/src/Module/routes.php");
        $viewsDir = $package->getRelativePackagePath("/src/resources/views");
        $migrationsDir = $package->getRelativePackagePath("/src/Migrations");

        if (File::exists($routesFile)) {
            // register routes
            $router = app('router');

            $router->group([
                'namespace' => $masterNamespace . "Controllers",
            ], function ($router) use ($routesFile) {
                require $routesFile;
            });
        }

        // register views if there is "src/resources/views" in the module
        if (is_dir($viewsDir)) {
            app('view')->addLocation($viewsDir);
        }

        // register migrations if there is "src/Migrations" in the module
        // after all the service providers booted
        if (is_dir($migrationsDir)) {
            app()->afterResolving('migrator', function () use ($migrationsDir) {
                app('migrator')->path($migrationsDir);
            });
        }

        // register seeders
        $this->modulesSeeders = array_merge($this->modulesSeeders, $this->getSeeders($package));
    }

    public function hasPackage(string $modulePackageName): bool
    {
        return $this->getPackage($modulePackageName) != null;
    }

    public function getPackage(string $package): ModulePackage|null
    {
        $packages = array_filter($this->loadedModules, fn($m) => $m->getName() == $package);

        if (count($packages) > 0) {
            return $packages[array_key_first($packages)];
        }

        return null;
    }

    public function activatePackage(ModulePackage $package)
    {
        $package->getAutoloader()->register();
        $package->getModule()->activate();

        $this->installAssets($package);

        $migrationsDir = $package->getRelativePackagePath("/src/Migrations");
        if (is_dir($migrationsDir)) {
            // perform migrations
            Artisan::call('migrate');
        }

        // save the changes in the DB
        DB::table('pb_modules')->updateOrInsert(['name' => $package->getName()], ['active' => 1]);
    }

    public function deactivatePackage(ModulePackage $package)
    {
        if($package->isCoreModule()) {
            throw new Exception("The module {$package->getName()} can't be disabled; it's critical to the functionality.");
        }

        // remove assets exposed to public
        Storage::disk('bundles')->deleteDirectory($package->getName());

        // revert changes
        $migrationsDir = $package->getRelativePackagePath("/src/Migrations");
        if (is_dir($migrationsDir)) {
            // ToDo: fix migration rollback
            Artisan::call('migrate:rollback', ['--path' => $migrationsDir . '/*']);
        }

        // save the changes in the DB
        DB::table('pb_modules')->updateOrInsert(['name' => $package->getName()], ['active' => 0]);

        $package->getModule()->deactivate();
        $package->getAutoloader()->unregister();

        // unload the plugin asap.
        $this->loadedModules = array_filter($this->loadedModules, fn($s) => $s !== $package);
    }

    protected function getPackageStateFromDB(string $package): object
    {
        $modules = array_filter($this->modulesDBList, fn($m) => $m->name == $package);

        if (count($modules) > 0) {
            return (object)$modules[array_key_first($modules)];
        }

        return (object)[
            "name" => $package,
            "active" => 0
        ];
    }

    protected function loadPackage(string $modulePath)
    {
        $composerMetadataPath = "{$modulePath}/composer.json";
        $packageName = basename($modulePath);

        if (File::exists($composerMetadataPath)) {
            $metadata = (object)json_decode(File::get($composerMetadataPath), true);

            if (isset($metadata->type) && ($metadata->type === self::POOKIEBOARD_MODULE_TYPE || $metadata->type === self::POOKIEBOARD_CORE_TYPE)) {
                // don't fully load the module package;
                // load only the metadata related to it;
                // what if a schmuck makes a malicious module?
                // we don't want any security issues to our CMS
                $this->loadedModules[] = new ModulePackage($packageName, $metadata, $modulePath, $this->getPackageStateFromDB($packageName)->active, $metadata->type === self::POOKIEBOARD_CORE_TYPE);
            }
        }
    }

    public function getLoadedModules()
    {
        return $this->loadedModules;
    }

    public function getModuleSeeders()
    {
        return $this->modulesSeeders;
    }

    public function installAssets(ModulePackage $package)
    {
        $allowedDirs = ["css", "js"];

        $bundlesDisk = Storage::disk('bundles');

        // delete the bundle folder for our package and remake it
        $bundlesDisk->deleteDirectory($package->getName());
        $bundlesDisk->makeDirectory($package->getName());

        $bundleDir = $bundlesDisk->path($package->getName());

        foreach ($allowedDirs as $dirName) {
            $resourceDir = $package->getRelativePackagePath(join_paths("src/resources", $dirName));

            if (is_dir($resourceDir)) {
                // make directory for our folder
                $bundlesDisk->makeDirectory(join_paths($package->getName(), $dirName));

                // recursively copy files to the bundle folder
                foreach (
                    $iterator = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($resourceDir, FilesystemIterator::SKIP_DOTS),
                        RecursiveIteratorIterator::SELF_FIRST) as $item
                ) {
                    $dest = join_paths($bundleDir,$dirName, $iterator->getSubPathname());

                    if ($item->isDir()) {
                        mkdir($dest);
                    } else {
                        copy($item, $dest);
                    }
                }
            }
        }
    }
}
