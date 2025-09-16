<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex items-center space-x-2 justify-center mb-4">
                <img class="w-10 h-10 rounded" src="{{ asset('images/logo.png') }}" alt="Logo">
                <span class="text-xl font-bold text-[#1b5d38]">CEYLON ESTATE</span>
            </div>
        </x-slot>

        <h2 class="text-xl font-bold text-center mb-4 text-gray-700">
            Welcome, Member!
        </h2>
        <p class="text-sm text-center text-gray-500 mb-6">
            Register your account to access the platform and explore properties.
        </p>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            {{-- Profile Photo --}}
            <div class="flex justify-center mb-6">
                <label for="profile_photo" class="relative cursor-pointer">
                    <!-- Circle placeholder with text -->
                    <div id="avatarPlaceholder" class="w-24 h-24 rounded-full border-2 border-indigo-400 flex items-center justify-center text-gray-400 font-semibold text-sm">
                        Profile Photo
                    </div>
                    <!-- Image preview -->
                    <img id="avatarPreview" class="w-24 h-24 rounded-full object-cover hidden border-2 border-indigo-400" alt="Profile Photo">
                    
                    <input id="profile_photo" type="file" name="profile_photo" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                    <div class="absolute bottom-0 right-0 bg-indigo-600 text-white rounded-full p-2 hover:bg-indigo-700 transition">
                        <i class="fas fa-camera"></i>
                    </div>
                </label>
            </div>

            {{-- Username --}}
            <div class="mt-4">
                <x-label for="username" value="{{ __('Username') }}" />
                <x-input id="username" class="block mt-1 w-full border-indigo-400" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            </div>

            {{-- First Name --}}
            <div class="mt-4">
                <x-label for="first_name" value="{{ __('First Name') }}" />
                <x-input id="first_name" class="block mt-1 w-full border-indigo-400" type="text" name="first_name" :value="old('first_name')" required autocomplete="given-name" />
            </div>

            {{-- Last Name --}}
            <div class="mt-4">
                <x-label for="last_name" value="{{ __('Last Name') }}" />
                <x-input id="last_name" class="block mt-1 w-full border-indigo-400" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
            </div>

            {{-- Hidden Role --}}
            <input type="hidden" name="role" value="member">

            {{-- Email --}}
            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full border-indigo-400" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            {{-- Password --}}
            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full border-indigo-400" type="password" name="password" required autocomplete="new-password" />
            </div>

            {{-- Confirm Password --}}
            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full border-indigo-400" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            {{-- Terms --}}
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />
                            <div class="ms-2 text-sm text-gray-600">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    {{-- Avatar Preview Script --}}
    <script>
        function previewAvatar(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('avatarPreview');
                const placeholder = document.getElementById('avatarPlaceholder');
                placeholder.classList.add('hidden');
                output.src = reader.result;
                output.classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-guest-layout>
