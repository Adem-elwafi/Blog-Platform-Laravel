<?php

namespace App\Http\Controllers;

use App\Models\Post;            // your Post model
use App\Models\User;            // for fetching authors
use App\Models\Comment;         // for stats
use App\Models\Like;            // for stats
use Illuminate\Http\Request;      // for handling form requests
use Illuminate\Support\Facades\Auth; // if you check current user
use Illuminate\Support\Facades\Storage; // for handling image storage

class PostController extends Controller
{
    /**
     * Display the welcome page with featured posts and stats.
     */
    public function welcome()
    {
        // Fetch 6 most recent posts with relationships for featured section
        $featuredPosts = Post::with(['user', 'likes', 'comments'])
            ->latest()
            ->take(6)
            ->get();
        
        // Calculate platform statistics for animated counter section
        $stats = [
            'posts' => Post::count(),
            'users' => User::count(),
            'comments' => Comment::count(),
            'likes' => Like::count(),
        ];
        
        return view('welcome', compact('featuredPosts', 'stats'));
    }

    /**
     * Display a listing of the resource.
     */
// In app/Http/Controllers/PostController.php
/**
 * Display a listing of the resource with optional filtering and sorting.
 */
public function index(Request $request)
{
    $query = Post::with([
        'user',
        'comments' => fn ($q) => $q->select('id', 'post_id'), // optimize comments loading
        'likes' => fn ($q) => $q->select('id', 'post_id'),    // optimize likes loading
    ]);

    // === SEARCH FILTER ===
    // Search in title and content (case-insensitive)
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'ILIKE', "%{$search}%")
              ->orWhere('content', 'ILIKE', "%{$search}%");
        });
    }

    // === AUTHOR FILTER ===
    // Filter by user_id if author parameter is provided
    if ($author = $request->integer('author')) {
        $query->where('user_id', $author);
    }

    // === SORTING LOGIC ===
    // Default to 'newest' if no sort parameter or invalid value
    $sort = $request->input('sort', 'newest');

    switch ($sort) {
        case 'popular':
            // Sort by number of likes (popularity)
            $query->withCount('likes')
                  ->orderBy('likes_count', 'desc')
                  ->orderBy('created_at', 'desc'); // secondary sort for tie-breaking
            break;

        case 'most_commented':
            // Sort by number of comments
            $query->withCount('comments')
                  ->orderBy('comments_count', 'desc')
                  ->orderBy('created_at', 'desc'); // secondary sort for tie-breaking
            break;

        case 'newest':
        default:
            // Default: sort by newest first (created_at desc)
            $query->latest();
            break;
    }

    // === PAGINATION ===
    // Paginate with 10 posts per page as required
    $posts = $query->paginate(10);

    // === GET AUTHORS WITH POSTS ===
    // Fetch all users who have published posts for the filter dropdown
    $authors = User::has('posts')
        ->select('id', 'name')
        ->orderBy('name')
        ->get();

    return view('posts.index', compact('posts', 'authors'));
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
        // Validate form inputs including optional image
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $validated['image'] = $imagePath;
        }

        // Add authenticated user ID
        $validated['user_id'] = Auth::id();

        // Create post with validated data
        $post = Post::create($validated);

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

            // Validate form inputs including optional image
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB
            ]);

            // Handle new image upload if provided
            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                
                // Store new image
                $imagePath = $request->file('image')->store('posts', 'public');
                $validated['image'] = $imagePath;
            }

            // Update post with validated data
            $post->update($validated);

            return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully.');
        }

        public function destroy(Post $post)
        {
            // Authorization check
            if (Auth::id() !== $post->user_id && Auth::user()->role !== 'admin') {
                abort(403);
            }

            // Delete associated image if it exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $post->delete();

            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        }
        

}
