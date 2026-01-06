<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AddImagesToPostsSeeder extends Seeder
{
    /**
     * Run the database seeds to add sample images to all posts
     */
    public function run(): void
    {
        // Create sample images directory if it doesn't exist
        if (!Storage::disk('public')->exists('posts')) {
            Storage::disk('public')->makeDirectory('posts');
        }

        $imageUrls = [
            'https://picsum.photos/800/600?random=1',
            'https://picsum.photos/800/600?random=2',
            'https://picsum.photos/800/600?random=3',
            'https://picsum.photos/800/600?random=4',
            'https://picsum.photos/800/600?random=5',
            'https://picsum.photos/800/600?random=6',
            'https://picsum.photos/800/600?random=7',
            'https://picsum.photos/800/600?random=8',
        ];

        $posts = Post::whereNull('image')->get();

        foreach ($posts as $index => $post) {
            try {
                // Get a random image URL
                $imageUrl = $imageUrls[$index % count($imageUrls)];
                
                // Download and save the image
                $imageContent = @file_get_contents($imageUrl);
                
                if ($imageContent) {
                    $filename = 'posts/post-' . $post->id . '-' . time() . '.jpg';
                    Storage::disk('public')->put($filename, $imageContent);
                    
                    // Update the post with the image path
                    $post->update(['image' => $filename]);
                    
                    $this->command->info("Added image to post #{$post->id}");
                }
            } catch (\Exception $e) {
                $this->command->warn("Failed to add image to post #{$post->id}: " . $e->getMessage());
            }
        }

        $this->command->info('Successfully added images to all posts without images!');
    }
}
