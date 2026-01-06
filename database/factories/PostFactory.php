<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraphs(asText: true),
            'image' => $this->generateDummyImage(),
        ];
    }

    /**
     * Generate a dummy image from an external source
     */
    private function generateDummyImage(): string
    {
        $imageUrls = [
            'posts/sample-1.jpg',
            'posts/sample-2.jpg',
            'posts/sample-3.jpg',
            'posts/sample-4.jpg',
            'posts/sample-5.jpg',
        ];
        
        return fake()->randomElement($imageUrls);
    }

}
