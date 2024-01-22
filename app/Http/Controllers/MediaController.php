<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Routing\Controller;
use Ramsey\Uuid\Uuid;

class MediaController extends Controller
{
    public function getMedia($id)
    {
        $media = Media::find(Uuid::fromString($id));

        // return 404 if the media entity does not exist in the DB
        if (!$media) {
            abort(404);
        }

        // if the file exists locally, we retrieve and return it, otherwise return 404
        if (Storage::disk('media')->exists($id)) {
            return response()->file(Storage::disk('media')->path($id));
        } else {
            abort(404);
        }
    }
}
