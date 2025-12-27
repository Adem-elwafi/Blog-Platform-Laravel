@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>
    <p class="text-gray-600 mb-4">by {{ $post->user->name }}</p>
    <div class="bg-white p-6 shadow rounded">
        {{ $post->content }}
    </div>
</div>
<div class="mt-6">
    <h2 class="text-xl font-bold mb-2">Comments</h2>

    @foreach($post->comments as $comment)
        <div class="p-4 bg-gray-100 rounded mb-2">
            <p>{{ $comment->body }}</p>
            <small class="text-gray-600">
                by {{ $comment->user->name }} on {{ $comment->created_at->format('d M Y H:i') }}
            </small>
        </div>
    @endforeach

    @auth
        <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="mt-4">
            @csrf
            <textarea name="body" class="w-full border rounded px-3 py-2" rows="3" required></textarea>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-2">Add Comment</button>
        </form>
    @endauth
</div>


@if(Auth::id() === $post->user_id || Auth::user()->role === 'admin')
    <div class="mt-4 flex space-x-2">
        <a href="{{ route('posts.edit', $post) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>

        <form method="POST" action="{{ route('posts.destroy', $post) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
        </form>
    </div>
@endif


@endsection
