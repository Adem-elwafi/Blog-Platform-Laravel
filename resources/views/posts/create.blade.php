@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-4">Create Post</h1>

    <form method="POST" action="{{ route('posts.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Title</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Content</label>
            <textarea name="content" class="w-full border rounded px-3 py-2" rows="5" required></textarea>
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Publish</button>
    </form>
</div>
@endsection
