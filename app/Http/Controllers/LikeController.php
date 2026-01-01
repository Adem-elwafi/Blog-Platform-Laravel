<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;


class LikeController extends Controller
{



public function toggle(Post $post)
{
    $user = Auth::user();

    $existingLike = Like::where('user_id', $user->id)
                        ->where('post_id', $post->id)
                        ->first();

    if ($existingLike) {
        $existingLike->delete();
        $liked = false;
    } else {
        Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        $liked = true;
    }

    // 👇 NEW PART (for React)
    if (request()->expectsJson()) {
        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes()->count(),
        ]);
    }

    // 👇 Old behavior stays
    return back();
}


}
