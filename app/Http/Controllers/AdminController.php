<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $posts = Post::with('user')->withCount(['comments','likes'])->get();
        $comments = Comment::with(['user','post'])->get();

        return view('admin.dashboard', compact('users','posts','comments'));
    }
}
