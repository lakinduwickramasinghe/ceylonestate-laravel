<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->user()?->currentAccessToken();

        if ($token) {
            // Example: expire after 7 days
            $expirationDays = 7;
            $createdAt = Carbon::parse($token->created_at);

            if ($createdAt->addDays($expirationDays)->isPast()) {
                // Revoke the expired token
                $token->delete();

                return response()->json([
                    'message' => 'Token expired. Please login again.'
                ], 401);
            }
        }

        return $next($request);
    }
}
