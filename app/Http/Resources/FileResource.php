<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin File
 */
class FileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->username,
            'previewUrl' => $this->previewUrl,
            'downloadUrl' => $this->downloadUrl,
            'filename' => $this->filename,
            'createdAt' => $this->timeCreated,
            'size' => humanReadableSize($this->size),
            'extension' => mimeTypeToExtension($this->mime_type),
            'width' => $this->width,
            'height' => $this->height,
        ];
    }
}
