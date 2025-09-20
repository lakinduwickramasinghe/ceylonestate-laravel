<x-guest-layout>
    @include('layouts.header')
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex items-center space-x-2 justify-center mb-4">
                {{-- <img class="w-10 h-10 rounded" src="{{ asset('images/logo.png') }}" alt="Logo">
                <span class="text-xl font-bold text-[#1b5d38]">CEYLON ESTATE</span> --}}
            </div>
        </x-slot>

        <h2 class="text-xl font-bold text-center mb-4 text-gray-700">
            Welcome Back, Member!
        </h2>
        <p class="text-sm text-center text-gray-500 mb-6">
            Login to access your account and explore your dashboard.
        </p>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 text-center">
                {{ $value }}
            </div>
        @endsession

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="login_role" value="member">

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full border-green-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full border-green-400" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md ms-4" href="{{ route('register') }}">
                    {{ __('Go to Register') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>

        <div class="flex items-center my-6">
            <hr class="w-full border-gray-300">
            <span class="px-3 text-gray-500">or</span>
            <hr class="w-full border-gray-300">
        </div>

        <!-- Google Login Button -->
        <div class="text-center">
            <a href="{{ url('auth/google') }}" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-md">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 488 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M488 261.8c0-17.7-1.5-35-4.5-51.8H249v98h135.4c-5.9 31-23.5 57.4-50 75.1v62h81c47.5-43.8 74.6-108.3 74.6-183.3z"/>
                    <path d="M249 492c67.5 0 124.3-22.3 165.7-60.7l-81-62c-22.5 15-51 23.9-84.7 23.9-65.2 0-120.3-43.9-140.1-102.7H25v64.7C66.3 436.5 152.2 492 249 492z"/>
                    <path d="M108.9 294.2c-5-15-7.9-31.2-7.9-48s2.9-33 7.9-48v-64.7H25c-23.5 46.7-23.5 101.3 0 148l83.9-64.7z"/>
                    <path d="M249 97.6c35.3 0 67 12.1 91.9 35.8l68.8-68.8C373.3 25.7 316.5 0 249 0 152.2 0 66.3 55.5 25 142.9l83.9 64.7C128.7 141.5 183.8 97.6 249 97.6z"/>
                </svg>
                Login with Google
            </a>
        </div>

    </x-authentication-card>
</x-guest-layout>
