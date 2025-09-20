<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Default avatar path
                $avatarPath = 'images/default-avatar.png';

                // Download Google avatar if available
                $googleAvatar = $googleUser->getAvatar();
                if ($googleAvatar) {
                    $filename = Str::random(20) . '.jpg';
                    Storage::disk('public')->put('profile-photos/' . $filename, file_get_contents($googleAvatar));
                    $avatarPath = 'profile-photos/' . $filename;
                }

                // Create new member user
                $user = User::create([
                    'first_name' => $googleUser->user['given_name'] ?? $googleUser->getName(),
                    'last_name' => $googleUser->user['family_name'] ?? '',
                    'username' => strtolower(str_replace(' ', '', $googleUser->getName())),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(uniqid()),
                    'role' => 'member',
                    'profile_photo_path' => $avatarPath,
                ]);
            }

            // Log in via Jetstream/Fortify
            Auth::login($user, true);

            // Redirect user
            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed.');
        }
    }
}
