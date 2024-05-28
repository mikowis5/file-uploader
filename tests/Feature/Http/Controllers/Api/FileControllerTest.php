<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
    }

    public function test_upload_image_smaller_than_500x500_fails()
    {
        $file = UploadedFile::fake()->image('small_image.jpg', 400, 400);

        $response = $this->postJson(route('files.store'), ['file' => $file, 'email' => $this->faker->email(), 'username' => $this->faker->userName()]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }

    public function test_upload_non_image_file_fails()
    {
        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $response = $this->postJson(route('files.store'), ['file' => $file, 'email' => $this->faker->email(), 'username' => $this->faker->userName()]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }

    public function test_upload_valid_image_passes()
    {
        $file = UploadedFile::fake()->image('large_image.jpg', 600, 600);

        $response = $this->postJson(route('files.store'), ['file' => $file, 'email' => $this->faker->email(), 'username' => $this->faker->userName()]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'File uploaded successfully.',
        ]);
    }

    public function test_index_returns_files()
    {
        // Arrange: Create some files in the database
        $files = File::factory()->count(3)->create();

        // Act: Make a GET request to the index route
        $response = $this->getJson(route('files.index'));

        $response->assertStatus(200);

        // Convert the response to JSON and check the contents
        $responseData = $response->json('data');

        $this->assertCount(3, $responseData);
    }

    public function test_destroy_removes_file()
    {
        // Arrange: Create a file in the database
        $file = File::factory()->create([
            'path' => 'uploads/testfile.txt',
            'email' => $this->faker->email(),
            'username' => $this->faker->userName(),
        ]);

        Storage::disk('local')->put('uploads/testfile.txt', 'dummy content');

        // Ensure the file exists in storage before deletion
        Storage::disk('local')->assertExists('uploads/testfile.txt');

        // Act: Make a DELETE request to the destroy route
        $response = $this->deleteJson(route('files.destroy', ['file' => $file->id]));

        // Assert: Check the response status and structure
        $response->assertStatus(200);

        // Verify that the file has been deleted from the database
        $this->assertDatabaseMissing('files', ['id' => $file->id]);

        // Verify that the file has been deleted from storage
        Storage::disk('local')->assertMissing('uploads/testfile.txt');
    }
}
