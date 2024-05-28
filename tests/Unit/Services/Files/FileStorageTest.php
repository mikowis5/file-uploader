<?php

namespace Tests\Unit\Services\Files;

use App\Services\Files\FileStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileStorageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
    }

    public function test_store()
    {
        $fileUploader = new FileStorage;

        // Create a mock UploadedFile
        $uploadedFile = UploadedFile::fake()->create('testfile.txt', 100);

        // Act
        $path = $fileUploader->store($uploadedFile);

        // Assert
        Storage::disk('local')->assertExists($path);
        $this->assertStringContainsString('uploads/', $path);
    }

    public function test_delete()
    {
        $fileUploader = new FileStorage;

        // Create a mock file in the storage
        $path = 'uploads/testfile.txt';
        Storage::disk('local')->put($path, 'test content');

        // Ensure the file exists before deletion
        Storage::disk('local')->assertExists($path);

        // Act
        $fileUploader->delete($path);

        // Assert
        Storage::disk('local')->assertMissing($path);
    }
}
