<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Welcome Back</h1>
        <p class="text-gray-600 dark:text-gray-400">Sign in to your account to continue</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input 
                id="email" 
                class="block mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 dark:text-red-400" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input 
                id="password" 
                class="block mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                type="password"
                name="password"
                required 
                autocomplete="current-password" 
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 dark:text-red-400" />
        </div>

        <!-- Remember Me -->
        <div class="block mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded focus:ring-blue-500 dark:focus:ring-blue-400 cursor-pointer" 
                    name="remember">
                <span class="ms-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col space-y-4">
            <x-primary-button class="w-full justify-center py-2 px-4 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white font-semibold rounded-lg transition">
                {{ __('Sign In') }}
            </x-primary-button>

            @if (Route::has('password.request'))
                <a class="text-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
            {{ __('Don\'t have an account?') }}
            <a class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold" href="{{ route('register') }}">
                {{ __('Register here') }}
            </a>
        </div>
    </form>
</x-guest-layout>
