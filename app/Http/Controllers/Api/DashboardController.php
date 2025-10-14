<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\PropertyAd;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'totalProperties' => PropertyAd::count(),
            'availableProperties' => PropertyAd::where('status','available')->count(),
            'soldProperties' => PropertyAd::where('status','sold')->count(),
            'latestProperties' => PropertyAd::latest()->take(3)->get(['title','status','created_at']),
            'totalUsers' => User::count(),
            'latestUsers' => User::latest()->take(3)->get(['first_name','email','created_at']),
        ]);
    }
    public function member(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return response()->json([
            'totalProperties' => PropertyAd::where('user_id', $user->id)->count(),
            'latestProperties' => PropertyAd::where('user_id', $user->id)
                                            ->latest()->take(3)
                                            ->get(['title','created_at']),
            'unreadMessages' => Chat::where('receiver_id', $user->id)
                                    ->where('seen', false)
                                    ->count(),

            'account' => [
                'memberSince' => $user->created_at->format('Y-m-d'),
                'email' => $user->email,
            ],
        ]);
    }


}
