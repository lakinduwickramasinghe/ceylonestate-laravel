<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Session;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
    ];

    public function boot(): void
    {
        parent::boot();

        // Login listener
        Event::listen(Login::class, function ($event) {
            $user = $event->user;

            // Create a Sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;

            // Store token in session
            session(['auth_token' => $token]);
        });

        // Logout listener
        Event::listen(Logout::class, function ($event) {
            $user = $event->user;

            if ($user) {
                // Delete all tokens for this user or just the current session token
                $user->tokens()->where('name', 'auth_token')->delete();
            }

            // Remove token from session
            Session::forget('auth_token');
        });
    

    }
}
