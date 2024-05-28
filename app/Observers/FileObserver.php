<?php

namespace App\Observers;

use App\Models\File;
use App\Services\Files\ImageService;

class FileObserver
{
    public function created(File $file): void
    {
        ImageService::storeImageDataIfFileIsImage($file);
    }
}
