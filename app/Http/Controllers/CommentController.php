<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // === Existing Web Methods (Blade form handlers) ===

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

    // === New API Methods (for React frontend) ===

    public function index(Post $post): JsonResponse
    {
        $comments = $post->comments()->with('user')->get();
        return response()->json(['comments' => $comments]);
    }

    public function apiStore(Request $request, Post $post): JsonResponse
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'body' => $request->input('body'),
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);

        $comment->load('user');

        return response()->json([
            'comment' => $comment,
            'message' => 'Comment added'
        ]);
    }

    public function apiDestroy(Comment $comment): JsonResponse
    {
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted']);
    }
}