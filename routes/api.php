<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PropertyAdController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // Special routes first
    Route::get('properties/member/{id}', [PropertyAdController::class,'member_property'])->name('properties.member');

    // Resource routes
    Route::apiResource('properties', PropertyAdController::class);

    // Users
    Route::apiResource('users', UserController::class);
    Route::get('users/{id}', [UserController::class, 'info'])->name('users.info');

    // Dashboard
    Route::apiResource('dashboard', DashboardController::class);
    Route::get('dashboard/member/{id}', [DashboardController::class, 'member'])->name('dashboard.member');


    // Feedback
    Route::apiResource('feedback', FeedbackController::class)->except(['index']);
    Route::get('feedback/member/{id}', [FeedbackController::class, 'member'])->name('feedback.member');


    // Notifications
    Route::apiResource('notifications', NotificationController::class)->only(['store','show','destroy']);
    Route::get('notification/user/{userId}', [NotificationController::class, 'index'])->name('notifications.user');
    Route::patch('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('notifications/{userId}/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
});

// Optional: view one property outside middleware if needed
Route::get('properties/{id}', [PropertyAdController::class, 'viewone'])->name('properties.viewone');
Route::get('properties/all', [PropertyAdController::class, 'all'])->name('properties.all');
Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback.index');
