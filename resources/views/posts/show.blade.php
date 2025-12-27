@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>
    <p class="text-gray-600 mb-4">by {{ $post->user->name }}</p>
    <div class="bg-white p-6 shadow rounded">
        {{ $post->content }}
    </div>
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
