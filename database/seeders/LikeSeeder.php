<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            // Randomly select 1-5 users to like each post
            $likedByUsers = $users->random(rand(1, min(5, $users->count())));
            
            foreach ($likedByUsers as $user) {
                // Check if like already exists to avoid duplicates
                if (!Like::where('user_id', $user->id)->where('post_id', $post->id)->exists()) {
                    Like::create([
                        'user_id' => $user->id,
                        'post_id' => $post->id,
                    ]);
                }
            }
        }
    }
}
