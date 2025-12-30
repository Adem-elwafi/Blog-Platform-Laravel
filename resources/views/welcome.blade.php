<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Blog Platform') }} - Share Your Stories</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Load GSAP -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            /* Simple, clean styles without conflicting animations */
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            .card-hover {
                transition: all 0.3s ease;
            }
            
            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }
            
            .nav-link {
                position: relative;
            }
            
            .nav-link::after {
                content: '';
                position: absolute;
                width: 0;
                height: 2px;
                bottom: -2px;
                left: 0;
                background: currentColor;
                transition: width 0.3s ease;
            }
            
            .nav-link:hover::after {
                width: 100%;
            }
            
            .hero-text {
                text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
            
            /* Background Image Styles */
            .hero-bg {
                background-image: 
                    linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                    url('https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                position: relative;
            }
            
            .hero-bg::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, 
                    rgba(59, 130, 246, 0.8) 0%, 
                    rgba(147, 51, 234, 0.8) 100%);
                mix-blend-mode: multiply;
            }
            
            .features-bg {
                background-image: 
                    linear-gradient(rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.92)),
                    url('https://images.unsplash.com/photo-1555099962-4199c345e5dd?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            }
            
            .dark .features-bg {
                background-image: 
                    linear-gradient(rgba(31, 41, 55, 0.92), rgba(31, 41, 55, 0.92)),
                    url('https://images.unsplash.com/photo-1555099962-4199c345e5dd?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
            }
            
            .cta-bg {
                background-image: 
                    linear-gradient(rgba(59, 130, 246, 0.85), rgba(147, 51, 234, 0.85)),
                    url('https://images.unsplash.com/photo-1453928582365-b6ad33cbcf64?ixlib=rb-4.0.3&auto=format&fit=crop&w=2073&q=80');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                position: relative;
                overflow: hidden;
            }
            
            .cta-bg::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: 
                    radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
                animation: float 20s infinite ease-in-out;
            }
            
            .footer-bg {
                background-image: 
                    linear-gradient(rgba(31, 41, 55, 0.95), rgba(17, 24, 39, 0.95)),
                    url('https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
                background-size: cover;
                background-position: center;
            }
            
            @keyframes float {
                0%, 100% {
                    transform: translate(0, 0) rotate(0deg);
                }
                33% {
                    transform: translate(30px, -20px) rotate(120deg);
                }
                66% {
                    transform: translate(-20px, 20px) rotate(240deg);
                }
            }
            
            /* For mobile devices, disable fixed background */
            @media (max-width: 768px) {
                .hero-bg,
                .features-bg,
                .cta-bg {
                    background-attachment: scroll;
                }
                
                .cta-bg::before {
                    animation: float-mobile 20s infinite ease-in-out;
                }
            }
            
            @keyframes float-mobile {
                0%, 100% {
                    transform: translate(0, 0);
                }
                50% {
                    transform: translate(10px, 10px);
                }
            }
            
            /* Glass morphism effect for cards */
            .glass-card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            .dark .glass-card {
                background: rgba(0, 0, 0, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            /* Loading fallback for animations */
            .js-loading [data-animate] {
                opacity: 0;
                transform: translateY(20px);
            }
        </style>
        
        <!-- Animation Script in Head -->
        <script>
            // Add loading class to body initially
            document.addEventListener('DOMContentLoaded', function() {
                document.body.classList.add('js-loading');
                
                // Register ScrollTrigger plugin
                if (typeof ScrollTrigger !== 'undefined') {
                    gsap.registerPlugin(ScrollTrigger);
                }

                // Check if user prefers reduced motion
                const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                
                if (prefersReducedMotion) {
                    // Show all elements immediately without animation
                    document.querySelectorAll('[data-animate]').forEach(el => {
                        el.style.opacity = '1';
                        el.style.transform = 'none';
                    });
                    document.body.classList.remove('js-loading');
                    return;
                }

                // Initial page load animations
                const animateElements = (selector, animation, delay = 0) => {
                    const elements = document.querySelectorAll(selector);
                    elements.forEach((el, index) => {
                        const elementDelay = parseFloat(el.getAttribute('data-delay')) || delay + (index * 0.1);
                        
                        switch(animation) {
                            case 'fade-in':
                                gsap.fromTo(el, 
                                    { opacity: 0 },
                                    {
                                        opacity: 1,
                                        duration: 0.8,
                                        delay: elementDelay,
                                        ease: "power2.out"
                                    }
                                );
                                break;
                                
                            case 'slide-up':
                                gsap.fromTo(el, 
                                    { opacity: 0, y: 30 },
                                    {
                                        opacity: 1,
                                        y: 0,
                                        duration: 0.8,
                                        delay: elementDelay,
                                        ease: "power2.out"
                                    }
                                );
                                break;
                                
                            case 'slide-left':
                                gsap.fromTo(el, 
                                    { opacity: 0, x: -30 },
                                    {
                                        opacity: 1,
                                        x: 0,
                                        duration: 0.8,
                                        delay: elementDelay,
                                        ease: "power2.out"
                                    }
                                );
                                break;
                                
                            case 'scale-in':
                                gsap.fromTo(el, 
                                    { opacity: 0, scale: 0.95 },
                                    {
                                        opacity: 1,
                                        scale: 1,
                                        duration: 0.8,
                                        delay: elementDelay,
                                        ease: "back.out(1.7)"
                                    }
                                );
                                break;
                        }
                    });
                };

                // Remove loading class and start animations
                setTimeout(() => {
                    document.body.classList.remove('js-loading');
                    
                    // Animate navigation first
                    animateElements('[data-animate="fade-in"]:not([data-delay])', 'fade-in', 0);
                    animateElements('[data-animate="slide-left"]', 'slide-left', 0.2);
                    animateElements('[data-animate="scale-in"]', 'scale-in', 0.3);

                    // Animate hero section with a slight delay
                    setTimeout(() => {
                        animateElements('h1[data-animate="slide-up"]', 'slide-up', 0);
                        animateElements('p[data-animate="slide-up"]', 'slide-up', 0.2);
                        animateElements('div[data-animate="scale-in"]', 'scale-in', 0.4);
                    }, 300);

                    // Animate features on scroll if ScrollTrigger is available
                    if (typeof ScrollTrigger !== 'undefined') {
                        // Features section animations
                        const features = document.querySelectorAll('.card-hover[data-animate="slide-up"]');
                        features.forEach(feature => {
                            const delay = parseFloat(feature.getAttribute('data-delay')) || 0;
                            
                            gsap.fromTo(feature, 
                                {
                                    opacity: 0,
                                    y: 50
                                },
                                {
                                    opacity: 1,
                                    y: 0,
                                    duration: 0.8,
                                    delay: delay,
                                    ease: "power2.out",
                                    scrollTrigger: {
                                        trigger: feature,
                                        start: "top 85%",
                                        toggleActions: "play none none none"
                                    }
                                }
                            );
                        });

                        // CTA section animations
                        const ctaElements = document.querySelectorAll('.cta-bg [data-animate]');
                        ctaElements.forEach(el => {
                            const animationType = el.getAttribute('data-animate');
                            const delay = parseFloat(el.getAttribute('data-delay')) || 0;
                            
                            let fromVars = { opacity: 0 };
                            if (animationType === 'slide-up') fromVars.y = 30;
                            if (animationType === 'scale-in') fromVars.scale = 0.95;
                            
                            gsap.fromTo(el, 
                                fromVars,
                                {
                                    opacity: 1,
                                    y: 0,
                                    scale: 1,
                                    duration: 0.8,
                                    delay: delay,
                                    ease: "power2.out",
                                    scrollTrigger: {
                                        trigger: el,
                                        start: "top 80%",
                                        toggleActions: "play none none none"
                                    }
                                }
                            );
                        });
                    } else {
                        // Fallback animation if ScrollTrigger not available
                        setTimeout(() => {
                            animateElements('.card-hover[data-animate="slide-up"]', 'slide-up', 0);
                            animateElements('.cta-bg [data-animate]', 'slide-up', 0.2);
                        }, 600);
                    }

                    // Add subtle floating animation to hero icon
                    const heroIcon = document.querySelector('.inline-flex.w-20.h-20');
                    if (heroIcon) {
                        gsap.to(heroIcon, {
                            y: -5,
                            duration: 2,
                            repeat: -1,
                            yoyo: true,
                            ease: "sine.inOut"
                        });
                    }

                    // Add hover effect to cards
                    document.querySelectorAll('.card-hover').forEach(card => {
                        card.addEventListener('mouseenter', () => {
                            gsap.to(card, {
                                y: -8,
                                duration: 0.3,
                                ease: "power2.out"
                            });
                        });
                        
                        card.addEventListener('mouseleave', () => {
                            gsap.to(card, {
                                y: 0,
                                duration: 0.3,
                                ease: "power2.out"
                            });
                        });
                    });
                }, 100);
            });
        </script>
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100">
        <div class="flex flex-col min-h-screen">
            <!-- Navigation -->
            <nav class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <a href="{{ url('/') }}" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 bg-clip-text text-transparent">
                                {{ config('app.name', 'Blog Platform') }}
                            </a>
                        </div>
                        <div class="flex items-center space-x-4">
                            @auth
                                <a href="{{ route('posts.index') }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium hidden md:inline-block">
                                    Explore Posts
                                </a>
                                <a href="{{ route('posts.create') }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <span>Create Post</span>
                                </a>
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium hidden md:inline-block">
                                        Admin
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                                    Get Started
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <main class="flex-grow">
                <div class="hero-bg">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-24 relative z-10">
                        <div class="text-center">
                            <div data-animate="scale-in" class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 mb-6">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                            
                            <h1 data-animate="slide-up" class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 hero-text">
                                Share Your
                                <span class="bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">Story</span>
                            </h1>
                            
                            <p data-animate="slide-up" data-delay="0.1" class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto mb-10">
                                A beautiful, modern platform for sharing ideas, connecting with readers, and building your audience.
                            </p>
                            
                            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                                <a href="{{ route('posts.index') }}" 
                                   data-animate="scale-in"
                                   class="px-8 py-3 bg-white text-blue-600 hover:bg-blue-50 rounded-xl font-semibold text-lg transition-all duration-300 shadow-xl hover:shadow-2xl flex items-center justify-center space-x-2">
                                    <span>Start Reading</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </a>
                                @guest
                                    <a href="{{ route('register') }}" 
                                       data-animate="scale-in"
                                       class="px-8 py-3 bg-transparent border-2 border-white text-white hover:bg-white/10 rounded-xl font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                                        Join Community
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="features-bg dark:bg-gray-800/50 py-16 lg:py-24">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center mb-12">
                            <h2 data-animate="slide-up" class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                                Everything You Need to <span class="text-blue-600 dark:text-blue-400">Share</span>
                            </h2>
                            <p data-animate="slide-up" data-delay="0.1" class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                                Powerful features designed to help you create, connect, and grow your audience
                            </p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Feature 1 -->
                            <div data-animate="slide-up" data-delay="0.1" class="card-hover bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-gray-200/50 dark:border-gray-700/50">
                                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 flex items-center justify-center mb-6">
                                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Beautiful Posts</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">
                                    Create stunning posts with our rich editor. Format text, add images, and make your content shine.
                                </p>
                                <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Rich text editor</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Image support</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Auto-save drafts</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Feature 2 -->
                            <div data-animate="slide-up" data-delay="0.2" class="card-hover bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-gray-200/50 dark:border-gray-700/50">
                                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 flex items-center justify-center mb-6">
                                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Engaging Discussions</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">
                                    Build meaningful conversations with threaded comments and real-time updates.
                                </p>
                                <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Threaded comments</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Real-time updates</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Mention users</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Feature 3 -->
                            <div data-animate="slide-up" data-delay="0.3" class="card-hover bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-gray-200/50 dark:border-gray-700/50">
                                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-red-100 to-pink-100 dark:from-red-900/30 dark:to-pink-900/30 flex items-center justify-center mb-6">
                                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Simple Engagement</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">
                                    Show appreciation and engagement with a clean, intuitive like system.
                                </p>
                                <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>One-click likes</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Like counters</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>User activity feed</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="cta-bg">
                    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 text-center relative z-10">
                        <h2 data-animate="slide-up" class="text-3xl md:text-4xl font-bold text-white mb-6">
                            Ready to Share Your Story?
                        </h2>
                        <p data-animate="slide-up" data-delay="0.1" class="text-xl text-white/90 mb-10 max-w-2xl mx-auto">
                            Join thousands of writers and thinkers who are already sharing their ideas with the world.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            @auth
                                <a href="{{ route('posts.create') }}" 
                                   data-animate="scale-in"
                                   class="px-8 py-3 bg-white text-blue-600 hover:bg-blue-50 rounded-xl font-semibold text-lg transition-all duration-300 shadow-xl hover:shadow-2xl">
                                    Create Your First Post
                                </a>
                                <a href="{{ route('posts.index') }}" 
                                   data-animate="scale-in"
                                   class="px-8 py-3 bg-transparent border-2 border-white text-white hover:bg-white/10 rounded-xl font-semibold text-lg transition-all duration-300">
                                    Explore Community
                                </a>
                            @else
                                <a href="{{ route('register') }}" 
                                   data-animate="scale-in"
                                   class="px-8 py-3 bg-white text-blue-600 hover:bg-blue-50 rounded-xl font-semibold text-lg transition-all duration-300 shadow-xl hover:shadow-2xl">
                                    Join Free Today
                                </a>
                                <a href="{{ route('posts.index') }}" 
                                   data-animate="scale-in"
                                   class="px-8 py-3 bg-transparent border-2 border-white text-white hover:bg-white/10 rounded-xl font-semibold text-lg transition-all duration-300">
                                    Browse Posts
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="footer-bg text-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <!-- Brand Column -->
                        <div class="md:col-span-1">
                            <div class="flex items-center space-x-2 mb-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <span class="text-xl font-bold text-white">{{ config('app.name', 'Blog Platform') }}</span>
                            </div>
                            <p class="text-gray-400 text-sm">
                                A modern platform for sharing stories and connecting with readers worldwide.
                            </p>
                        </div>

                        <!-- Quick Links -->
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-4">Platform</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('posts.index') }}" class="text-gray-400 hover:text-white transition-colors">Explore Posts</a></li>
                                <li><a href="{{ route('posts.create') }}" class="text-gray-400 hover:text-white transition-colors">Create Post</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Top Writers</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Categories</a></li>
                            </ul>
                        </div>

                        <!-- Resources -->
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-4">Resources</h3>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Community</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Support</a></li>
                            </ul>
                        </div>

                        <!-- Connect -->
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-4">Connect</h3>
                            <ul class="space-y-2">
                                <li><a href="https://github.com/Adem-dev/blog-platform" target="_blank" rel="noopener" class="text-gray-400 hover:text-white transition-colors flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                    </svg>
                                    <span>GitHub</span>
                                </a></li>
                                <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Twitter</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Discord</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-700 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                        <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} {{ config('app.name', 'Blog Platform') }}. All rights reserved.</p>
                        <div class="flex items-center gap-6 text-sm">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">Contact</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>