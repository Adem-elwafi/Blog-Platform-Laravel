@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h1 class="text-2xl font-bold">Admin Dashboard</h1>
            <p>Welcome, {{ Auth::user()->name }}! You have admin privileges.</p>
        </div>
    </div>
</div>
@endsection
