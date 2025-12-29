<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-2">All Posts</h1>
                <p class="text-gray-600 dark:text-gray-400">Discover and read articles from our community</p>
            </div>
            @auth
                <a href="{{ route('posts.create') }}" class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg font-semibold transition shadow-md hover:shadow-lg" aria-label="Create a new post">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Post
                </a>
            @endauth
        </div>

        <!-- Posts Grid -->
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition overflow-hidden group">
                        <!-- Post Image Placeholder -->
                        <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 dark:from-blue-700 dark:to-blue-900 flex items-center justify-center text-white text-6xl font-bold overflow-hidden">
                            {{ substr($post->title, 0, 1) }}
                        </div>

                        <!-- Post Content -->
                        <div class="p-6">
                            <!-- Category/Badge -->
                            <div class="mb-2 flex flex-wrap gap-2">
                                <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold rounded-full">
                                    Article
                                </span>
                            </div>

                            <!-- Title -->
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                            </h2>

                            <!-- Excerpt -->
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                {{ Str::limit($post->content, 150, '...') }}
                            </p>

                            <!-- Meta Information -->
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center space-x-2">
                                    <div class="h-6 w-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $post->user->name }}</span>
                                </div>
                                <time datetime="{{ $post->created_at->toAtomString() }}" class="text-xs">
                                    {{ $post->created_at->diffForHumans() }}
                                </time>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 mb-4">
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center" aria-label="Comment count">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        {{ $post->comments()->count() }}
                                    </span>
                                    <span class="flex items-center" aria-label="Like count">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        {{ $post->likes()->count() }}
                                    </span>
                                </div>
                            </div>

                            <!-- Read More Button -->
                            <a href="{{ route('posts.show', $post) }}" class="w-full block text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg font-semibold transition">
                                Read More
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No posts yet</h3>
                <p class="mt-1 text-gray-600 dark:text-gray-400">Get started by creating your first post.</p>
                @auth
                    <div class="mt-6">
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg font-semibold transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Post
                        </a>
                    </div>
                @else
                    <div class="mt-6">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg font-semibold transition">
                            Sign in to create a post
                        </a>
                    </div>
                @endauth
            </div>
        @endif
    </div>
</x-app-layout>
