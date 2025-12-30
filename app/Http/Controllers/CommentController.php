<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{

public function store(Request $request, Post $post)
{
    $request->validate([
        'body' => 'required|string|max:1000',
    ]);

    Comment::create([
        'body' => $request->input('body'),
        'user_id' => Auth::id(),
        'post_id' => $post->id,
    ]);

    return back()->with('success', 'Comment added successfully.');
}

public function destroy(Comment $comment)
{
    // Check if user is authorized to delete this comment
    if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
        return back()->with('error', 'Unauthorized to delete this comment.');
    }

    $post = $comment->post;
    $comment->delete();

    return back()->with('success', 'Comment deleted successfully.');
}

}
