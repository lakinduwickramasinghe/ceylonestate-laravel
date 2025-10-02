<?php

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\CheckTokenExpiration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PropertyAdController;

Route::middleware(['auth:sanctum',CheckTokenExpiration::class])->group(function () {

    Route::apiResource('property', PropertyAdController::class);
    Route::get('property/member/{id}',[PropertyAdController::class,'member_property'])->name('member.properties');
    Route::post('/property/create', [PropertyAdController::class, 'store']);

    Route::apiResource('user', UserController::class);

    Route::apiResource('feedback', FeedbackController::class);

    Route::get('user/{id}', [UserController::class, 'info'])->name('user.info');

    Route::get('feedback/member/{id}', [FeedbackController::class, 'member']);

    Route::apiResource('notification', NotificationController::class)->only(['store', 'show', 'destroy']);
    Route::get('notification/user/{userId}', [NotificationController::class, 'index']);
    Route::patch('/notification/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::patch('/notifications/{userId}/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    
});


Route::get('/properties',[PropertyAdController::class,'all']);
Route::get('/properties/{id}',[PropertyAdController::class,'viewone']);

