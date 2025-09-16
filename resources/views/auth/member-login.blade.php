<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex items-center space-x-2 justify-center mb-4">
                <img class="w-10 h-10 rounded" src="{{ asset('images/logo.png') }}" alt="Logo">
                <span class="text-xl font-bold text-[#1b5d38]">CEYLON ESTATE</span>
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

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
