<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'filename' => $this->faker->word . '.' . $this->faker->fileExtension(),
            'path' => 'uploads/' . $this->faker->uuid,
            'size' => $this->faker->numberBetween(1000, 1000000),
            'mime_type' => $this->faker->mimeType(),
            'width' => 1000,
            'height' => 1000,
            'email' => $this->faker->email(),
            'username' => $this->faker->userName(),
        ];
    }
}
