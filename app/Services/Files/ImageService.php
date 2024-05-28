<?php

namespace App\Services\Files;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    public static function storeImageDataIfFileIsImage(File $file): void
    {
        if (self::isImage($file)) {
            self::storeImageData($file);
        }
    }

    public static function isImage(File $file): bool
    {
        try {
            Image::make(Storage::path($file->path));
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function storeImageData(File &$file): void
    {
        $image = Image::make(Storage::path($file->path));

        $file->width = $image->width();
        $file->height = $image->height();
        $file->exif = json_encode($image->exif()) ?: null;
        $file->iptc = json_encode($image->iptc()) ?: null;

        $file->save();
    }
}
