<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Create Account</h1>
        <p class="text-gray-600 dark:text-gray-400">Join our community and start sharing your stories</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input 
                id="name" 
                class="block mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 dark:text-red-400" />
        </div>

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
                autocomplete="new-password" 
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 dark:text-red-400" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input 
                id="password_confirmation" 
                class="block mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password" 
            />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 dark:text-red-400" />
        </div>

        <div class="flex flex-col space-y-4">
            <x-primary-button class="w-full justify-center py-2 px-4 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white font-semibold rounded-lg transition">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
            {{ __('Already registered?') }}
            <a class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold" href="{{ route('login') }}">
                {{ __('Sign in here') }}
            </a>
        </div>
    </form>
</x-guest-layout>
