<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Routing\Controller;
use Ramsey\Uuid\Uuid;

class BundleController extends Controller
{
    public function getBundleFile($file)
    {
        $bundlesDisk = Storage::disk('bundles');

        // if the file exists locally, we retrieve and return it, otherwise return 404
        if ($bundlesDisk->exists($file)) {
            $filePath = $bundlesDisk->path($file);
            $mimeType = $bundlesDisk->mimeType($file);

            return response()->file($filePath, ['Content-Type' => $mimeType]);
        } else {
            abort(404);
        }
    }
}
