<?php

namespace Tests\Unit\Repositories;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\File;
use App\Repositories\FileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class FileRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_createFromUploadedFile()
    {
        // Arrange
        $fileRepository = new FileRepository();

        // Mock the UploadedFile
        $uploadedFile = Mockery::mock(UploadedFile::class);
        $uploadedFile->shouldReceive('getClientOriginalName')->andReturn('testfile.txt');
        $uploadedFile->shouldReceive('getSize')->andReturn(12345);
        $uploadedFile->shouldReceive('getClientMimeType')->andReturn('text/plain');

        $filePath = 'uploads/testfile.txt';
        $uploadedFile->shouldReceive('getRealPath')->andReturn($filePath);

        // Act
        $fileRecord = $fileRepository->createFromUploadedFile($uploadedFile, $this->faker->email(), $this->faker->userName(), $filePath);

        // Assert
        $this->assertDatabaseHas('files', [
            'filename' => 'testfile.txt',
            'path' => $filePath,
            'size' => 12345,
            'mime_type' => 'text/plain',
        ]);

        $this->assertInstanceOf(File::class, $fileRecord);
        $this->assertEquals('testfile.txt', $fileRecord->filename);
        $this->assertEquals($filePath, $fileRecord->path);
        $this->assertEquals(12345, $fileRecord->size);
        $this->assertEquals('text/plain', $fileRecord->mime_type);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

