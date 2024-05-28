<?php

namespace App\Repositories;

use App\Models\File;
use Illuminate\Http\UploadedFile;

class FileRepository
{
    public function createFromUploadedFile(UploadedFile $file, string $email, string $username, string $path): File
    {
        return File::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'size' => $file->getSize(),
            'mime_type' => $file->getClientMimeType(),
            'email' => $email,
            'username' => $username,
        ]);
    }
}
