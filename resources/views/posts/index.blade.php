@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-4">All Posts</h1>
    <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">New Post</a>

    <div class="mt-6 space-y-4">
        @foreach ($posts as $post)
            <div class="p-4 bg-white shadow rounded">
                <h2 class="text-xl font-semibold">
                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                </h2>
                <p class="text-gray-600">by {{ $post->user->name }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
