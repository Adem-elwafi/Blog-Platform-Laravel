<?php

namespace App\Http\Controllers;

use App\Models\Post;            // your Post model
use Illuminate\Http\Request;      // for handling form requests
use Illuminate\Support\Facades\Auth; // if you check current user

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
// In app/Http/Controllers/PostController.php
public function index()
{
    // Use paginate() instead of get() or all()
    $posts = Post::with(['user', 'comments', 'likes'])
                ->latest()
                ->paginate(12); // or whatever number you prefer
    
    return view('posts.index', compact('posts'));
}
public function create()
{
    return view('posts.create');
}

public function show(Post $post)
{
    return view('posts.show', compact('post'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->get('content'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Post created successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     */
        public function edit(Post $post)
        {
            // Authorization check
            if (Auth::id() !== $post->user_id && Auth::user()->role !== 'admin') {
                abort(403);
            }
            return view('posts.edit', compact('post'));
        }

        public function update(Request $request, Post $post)
        {
            // Authorization check
            if (Auth::id() !== $post->user_id && Auth::user()->role !== 'admin') {
                abort(403);
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            $post->update([
                'title' => $request->title,
                'content' => $request->get('content'),
            ]);

            return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully.');
        }

        public function destroy(Post $post)
        {
            // Authorization check
            if (Auth::id() !== $post->user_id && Auth::user()->role !== 'admin') {
                abort(403);
            }

            $post->delete();

            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        }
        

}
