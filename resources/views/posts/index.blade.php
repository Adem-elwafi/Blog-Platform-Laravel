<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-2xl mx-auto px-4">
            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Discover Stories
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Explore amazing content from our community
                </p>
            </div>

            <!-- Create Post Button (Floating) -->
            @auth
                <div class="mb-6">
                    <a href="{{ route('posts.create') }}" 
                       class="flex items-center justify-center w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white rounded-xl py-4 px-6 font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Post
                    </a>
                </div>
            @endauth

            <!-- Filters Section (React Component) -->
            <div class="mb-6">
                <div 
                    data-component="PostFilters"
                    data-authors="{{ json_encode($authors) }}"
                    data-initial-search="{{ request('search', '') }}"
                    data-initial-author="{{ request('author', '') }}"
                    data-initial-sort="{{ request('sort', 'newest') }}"
                ></div>
            </div>

            <!-- Posts Feed -->
            <div class="space-y-6" id="posts-feed">
                @forelse($posts as $post)
                    <article class="post-card bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                        <!-- Post Header -->
                        <div class="flex items-center justify-between p-4">
                            <div class="flex items-center space-x-3">
                                <!-- User Avatar -->
                                <a href="#" class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-400 via-pink-500 to-red-500 flex items-center justify-center text-white font-bold ring-2 ring-white dark:ring-gray-800">
                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                    </div>
                                </a>
                                
                                <!-- User Info -->
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">
                                        {{ $post->user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $post->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            <!-- Options Menu (for post owner) -->
                            @if(Auth::id() === $post->user_id || Auth::user()?->role === 'admin')
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>

                                    <div x-show="open" 
                                         @click.away="open = false"
                                         x-transition
                                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg py-1 z-10">
                                        <a href="{{ route('posts.edit', $post) }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            Edit Post
                                        </a>
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}" 
                                              onsubmit="return confirm('Delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                Delete Post
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Post Image -->
                        @if($post->image)
                            <div class="relative">
                                <a href="{{ route('posts.show', $post) }}">
                                    <img src="{{ asset('storage/' . $post->image) }}" 
                                         alt="{{ $post->title }}"
                                         class="w-full h-auto max-h-[600px] object-cover cursor-pointer hover:opacity-95 transition-opacity"
                                         loading="lazy">
                                </a>
                            </div>
                        @endif

                        <!-- Engagement Bar (Like, Comment, Views) -->
                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <!-- Like Button (React Island) -->
                                    <div 
                                        data-component="LikeButton"
                                        data-post-id="{{ $post->id }}"
                                        data-initial-liked="{{ auth()->check() && auth()->user()->likes()->where('post_id', $post->id)->exists() ? 'true' : 'false' }}"
                                        data-initial-likes-count="{{ $post->likes_count }}"
                                        data-is-authenticated="{{ auth()->check() ? 'true' : 'false' }}"
                                    ></div>

                                    <!-- Comments Count -->
                                    <a href="{{ route('posts.show', $post) }}#comments" 
                                       class="flex items-center space-x-1 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">{{ $post->comments_count }}</span>
                                    </a>
                                </div>

                                <!-- Share/Bookmark (Optional) -->
                                <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Post Content -->
                        <div class="p-4">
                            <a href="{{ route('posts.show', $post) }}">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2 hover:text-blue-600 dark:hover:text-blue-400 transition">
                                    {{ $post->title }}
                                </h2>
                            </a>

                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-3">
                                {{ \Illuminate\Support\Str::limit($post->content, 150) }}
                            </p>

                            <a href="{{ route('posts.show', $post) }}" 
                               class="inline-flex items-center text-blue-600 dark:text-blue-400 font-semibold hover:text-blue-700 dark:hover:text-blue-300 transition">
                                Read More
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                    </article>
                @empty
                    <!-- Empty State -->
                    <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No posts found</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            @if(request()->has('search') || request()->has('author'))
                                Try adjusting your filters
                            @else
                                Be the first to share your story!
                            @endif
                        </p>
                        @auth
                            <a href="{{ route('posts.create') }}" 
                               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create First Post
                            </a>
                        @endauth
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @endif

        </div>
    </div>

    <!-- GSAP Scroll Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate post cards on scroll
            gsap.from('.post-card', {
                scrollTrigger: {
                    trigger: '#posts-feed',
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                },
                duration: 0.6,
                y: 40,
                opacity: 0,
                stagger: 0.15,
                ease: 'power2.out'
            });

            // Smooth hover effect for cards (optional enhancement)
            document.querySelectorAll('.post-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    gsap.to(this, {
                        y: -4,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });

                card.addEventListener('mouseleave', function() {
                    gsap.to(this, {
                        y: 0,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });
            });
        });
    </script>
</x-app-layout>