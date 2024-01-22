<?php

namespace App\Models;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use function Illuminate\Filesystem\join_paths;

class Media extends PBModel
{
    protected $table = "pb_media";

    public function fromFile($filePath)
    {
        $this->originalName = basename($filePath);

        // register a saving event so that after we saved the document,
        // we make sure we're writing the content of the file we want to store.
        self::saved(function ($model) use ($filePath) {
            $model->writeContent(new File($filePath));
        });
    }

    public function writeContent($content)
    {
        Storage::putFileAs('media', $content, $this->id);
    }

    public function getUrl()
    {
        return Storage::disk('media')->url($this->id);
    }
}
