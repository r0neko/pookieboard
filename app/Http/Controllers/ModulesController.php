<?php

namespace App\Http\Controllers;

use App\PookieBoard\Modules\ModuleManager;
use Illuminate\Support\Facades\Request;
use Laravel\Lumen\Routing\Controller;

class ModulesController extends Controller
{
    public function index(Request $req, ModuleManager $manager) {
        return view("cms.page.modules", [
            "modules" => $manager->getLoadedModules()
        ]);
    }
}
