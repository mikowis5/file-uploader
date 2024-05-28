<?php

namespace App\Services\Files;

use App\Events\FileUploaded;
use App\Models\File;
use App\Repositories\FileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class FilesService
{
    public function __construct(private FileStorage $fileStorage, private FileRepository $repository)
    {
    }

    /**
     * @param iterable<UploadedFile> $files
     * @return Collection<File>
     */
    public function uploadAndPersist(iterable $files, string $email, string $username): Collection
    {
        return collect($files)
            ->map(function (UploadedFile $file) use ($email, $username) {
                $path = $this->fileStorage->store($file);

                $file = $this->repository->createFromUploadedFile($file, $email, $username, $path);

                event(new FileUploaded($file));

                return $file;
            });
    }

    public function remove(File $file): void
    {
        $this->fileStorage->delete($file->path);

        $file->delete();
    }
}
