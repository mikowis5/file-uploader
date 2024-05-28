<?php

namespace App\Services\Files;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileStorage
{
    /**
     * Store a file and returns path to newly uploaded resource
     */
    public function store(UploadedFile $file): string
    {
        return $file->store('uploads');
    }

    public function delete(string $path): bool
    {
        return Storage::delete($path);
    }
}
