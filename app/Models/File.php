<?php

namespace App\Models;

use App\Observers\FileObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $path
 * @property string $filename
 * @property int $size
 * @property string $mime_type
 * @property int $width
 * @property int $height
 * @property string $exif
 * @property string $iptc
 * @property string $username
 * @property string $email
 *
 * @property string $previewUrl
 * @property string $timeCreated
 * @property string $downloadUrl
 * @property float $mbSize
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class File extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted(): void
    {
        parent::booted();

        static::observe(FileObserver::class);
    }

    public function getPreviewUrlAttribute(): string
    {
        return route('file.preview', ['file' => $this]);
    }

    public function getDownloadUrlAttribute(): string
    {
        return route('file.download', ['file' => $this]);
    }

    public function getTimeCreatedAttribute(): string
    {
        if ($this->created_at > now()->subMinute()) {
            return "Just now";
        }

        return $this->created_at->diffForHumans();
    }
}
