<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run()
{
    $posts = Post::all();
    foreach ($posts as $post) {
        Comment::factory()->count(2)->create([
            'post_id' => $post->id,
            'user_id' => User::inRandomOrder()->first()->id,
        ]);
    }
}

}
