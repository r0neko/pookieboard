<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Laravel\Lumen\Routing\Controller;

class AdminController extends Controller
{
    public function index(Request $req) {
        return view("cms.page.home");
    }
}
