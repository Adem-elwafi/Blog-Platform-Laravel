<x-app-layout>
    <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Post Header -->
        <header class="mb-8">
            <div class="mb-4 flex flex-wrap gap-2">
                <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold rounded-full">
                    Article
                </span>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                {{ $post->title }}
            </h1>

            <!-- Post Meta -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-200 dark:border-gray-700 pb-4">
                <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                    <div class="h-12 w-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr($post->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $post->created_at->format('F j, Y') }}
                        </p>
                    </div>
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="block">Reading time: ~{{ ceil(str_word_count($post->content) / 200) }} min</span>
                </div>
            </div>
        </header>

        <!-- Post Content -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 md:p-8 mb-8 prose dark:prose-invert max-w-none">
            <div class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">
                {{ $post->content }}
            </div>
        </div>

        <!-- Post Actions -->
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <!-- Like Button -->
                <div>
                    @auth
                        <form method="POST" action="{{ route('posts.like', $post) }}" class="inline">
                            @csrf
                            <button type="submit" 
                                class="flex items-center space-x-2 px-6 py-3 rounded-lg font-semibold transition {{ auth()->user()->likes()->where('post_id', $post->id)->exists() ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white' }}"
                                aria-label="{{ auth()->user()->likes()->where('post_id', $post->id)->exists() ? 'Unlike' : 'Like' }} this post">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path>
                                </svg>
                                <span>
                                    {{ auth()->user()->likes()->where('post_id', $post->id)->exists() ? 'Unlike' : 'Like' }}
                                </span>
                                <span class="text-sm bg-opacity-20 px-2 py-1 rounded">
                                    {{ $post->likes()->count() }}
                                </span>
                            </button>
                        </form>
                    @else
                        <div class="flex items-center space-x-2 px-6 py-3 bg-gray-200 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span>{{ $post->likes()->count() }} Likes</span>
                        </div>
                    @endauth
                </div>

                <!-- Edit/Delete Actions -->
                @if(Auth::id() === $post->user_id || Auth::user()?->role === 'admin')
                    <div class="flex gap-2">
                        <a href="{{ route('posts.edit', $post) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>

                        <form method="POST" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('Are you sure?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Comments Section -->
        <section class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                Comments <span class="text-gray-600 dark:text-gray-400">({{ $post->comments()->count() }})</span>
            </h2>

            <!-- Comment Form -->
            @auth
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 mb-8 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Leave a Comment</h3>
                    <form method="POST" action="{{ route('posts.comments.store', $post) }}">
                        @csrf
                        <div class="mb-4">
                            <textarea name="body" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" 
                                rows="4" 
                                placeholder="Share your thoughts..." 
                                required
                                aria-label="Comment body"></textarea>
                            @error('body')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg font-semibold transition">
                            Post Comment
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-6 mb-8">
                    <p class="text-blue-800 dark:text-blue-200">
                        <a href="{{ route('login') }}" class="font-semibold hover:underline">Sign in</a> to leave a comment.
                    </p>
                </div>
            @endauth

            <!-- Comments List -->
            @if($post->comments()->count() > 0)
                <div class="space-y-4">
                    @foreach($post->comments as $comment)
                        <article class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                            <!-- Comment Header -->
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Comment Body -->
                            <p class="text-gray-700 dark:text-gray-300 mb-3 leading-relaxed">
                                {{ $comment->body }}
                            </p>

                            <!-- Comment Actions -->
                            @if(Auth::id() === $comment->user_id || Auth::user()?->role === 'admin')
                                <div class="flex gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirm('Delete this comment?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">No comments yet. Be the first to comment!</p>
                </div>
            @endif
        </section>

        <!-- Back to Posts Link -->
        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('posts.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-semibold transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Posts
            </a>
        </div>
    </article>
</x-app-layout>
