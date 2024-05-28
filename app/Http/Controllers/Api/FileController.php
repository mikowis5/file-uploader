<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\FileUploadRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Services\Files\FilesService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends ApiController
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $timestamp = $request->has('timestamp') ? Carbon::createFromTimestamp($request->get('timestamp')) : now();

        return FileResource::collection(
            File::query()
                ->where('created_at', '<=', $timestamp)
                ->orderByDesc('created_at')
                ->paginate(20)
        );
    }

    public function store(FileUploadRequest $request, FilesService $filesService): JsonResponse
    {
        if (! $request->hasFiles()) {
            return $this->fail('File could not be found in the request', 400);
        }

        try {
            $files = $filesService->uploadAndPersist($request->getFiles(), $request->email, $request->username);
        } catch (\Throwable $e) {
            return $this->fail($e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'File uploaded successfully.',
            'file' => FileResource::collection($files)[0],
        ]);
    }

    public function destroy(File $file, FilesService $filesService): JsonResponse
    {
        try {
            $filesService->remove($file);
        } catch (\Throwable $e) {
            return $this->fail($e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'File removed successfully.',
        ]);
    }

    public function download(File $file): StreamedResponse
    {
        if (! Storage::exists($file->path)) {
            abort(404, 'File not found.');
        }

        return Storage::download($file->path, $file->filename);
    }

    public function preview(File $file): StreamedResponse
    {
        if (! Storage::exists($file->path)) {
            abort(404, 'File not found.');
        }

        $mimeType = Storage::mimeType($file->path);

        return response()->stream(function () use ($file) {
            echo Storage::get($file->path);
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.$file->filename.'"'
        ]);
    }
}
