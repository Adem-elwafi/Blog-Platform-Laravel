@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>
    <p class="text-gray-600 mb-4">by {{ $post->user->name }}</p>
    <div class="bg-white p-6 shadow rounded">
        {{ $post->content }}
    </div>
</div>
@endsection
