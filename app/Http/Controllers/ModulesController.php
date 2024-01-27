<?php

namespace App\Http\Controllers;

use App\PookieBoard\Modules\ModuleManager;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class ModulesController extends Controller
{
    public function index(Request $req, ModuleManager $manager)
    {
        return view("cms.page.modules", [
            "modules" => $manager->getLoadedModules()
        ]);
    }

    public function activate(Request $request, ModuleManager $manager, $module)
    {
        $package = $manager->getPackage($module);

        if (!$package) {
            $request->session()->flash('cms.alert.danger', "The '{$module}' module does not exist!");
        } else {
            if ($package->isActive()) {
                $request->session()->flash('cms.alert.warning', "The '{$module}' module is already active!");
            } else {
                try {
                    $manager->activatePackage($package);
                    $manager->installAssets($package);
                    $request->session()->flash('cms.alert.success', "The '{$module}' module was activated successfully.");
                } catch (\Exception $e) {
                    $request->session()->flash('cms.alert.danger', "An error occurred while activating the '{$module}' module: {$e->getMessage()}");
                }
            }
        }

        return redirect(route("cms.modules"));
    }

    public function deactivate(Request $request, ModuleManager $manager, $module)
    {
        $package = $manager->getPackage($module);

        if (!$package) {
            $request->session()->flash('cms.alert.danger', "The '{$module}' module does not exist!");
        } else {
            if (!$package->isActive()) {
                $request->session()->flash('cms.alert.warning', "The '{$module}' module is already inactive!");
            } else {
                try {
                    $manager->deactivatePackage($package);
                    $request->session()->flash('cms.alert.success', "The '{$module}' module was disabled successfully.");
                } catch (\Exception $e) {
                    $request->session()->flash('cms.alert.danger', "An error occurred while disabling the '{$module}' module: {$e->getMessage()}");
                }
            }
        }

        return redirect(route("cms.modules"));
    }
}
