<?php

namespace App\PookieBoard\Modules;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ModuleManager
{
    protected $loadedModules = [];
    protected $modulesDBList = [];

    public const POOKIEBOARD_MODULE_TYPE = 'pookieboard-module';

    public function loadPackages()
    {
        $this->modulesDBList = DB::table("pb_modules")->get()->all();

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

    public function registerPackage(ModulePackage $package) {
        if(!$package->isActive()) return;

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

    public function activatePackage(ModulePackage $package) {
        $package->getAutoloader()->register();
        $package->getModule()->activate();

        // save the changes in the DB
        DB::table('pb_modules')->updateOrInsert(['name' => $package->getName()], ['active' => 1]);
    }

    public function deactivatePackage(ModulePackage $package) {
        $package->getModule()->deactivate();

        // save the changes in the DB
        DB::table('pb_modules')->updateOrInsert(['name' => $package->getName()], ['active' => 0]);

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
            $metadata = (object) json_decode(File::get($composerMetadataPath), true);

            if (isset($metadata->type) && $metadata->type === self::POOKIEBOARD_MODULE_TYPE) {
                // don't fully load the module package;
                // load only the metadata related to it;
                // what if a schmuck makes a malicious module?
                // we don't want any security issues to our CMS
                $this->loadedModules[] = new ModulePackage($packageName, $metadata, $modulePath, $this->getPackageStateFromDB($packageName)->active);
            }
        }
    }

    public function getLoadedModules()
    {
        return $this->loadedModules;
    }
}
