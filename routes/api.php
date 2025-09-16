<?php

use App\Http\Controllers\api\ChatController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PropertyAdController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('property', PropertyAdController::class);
Route::get('property/member/{id}',[PropertyAdController::class,'member_property'])->name('member.properties');
Route::post('/property/create', [PropertyAdController::class, 'store']);

Route::apiResource('user', UserController::class);

Route::middleware(['auth'])->group(function () {

    Route::get('/chat', [ChatController::class, 'showChatPage'])->name('chat.page');
    Route::get('/chat/{userId}', [ChatController::class, 'openChat'])->name('chat.open');
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.send');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'index'])->name('chat.messages');
    Route::post('/chat/seen/{userId}', [ChatController::class, 'markAsSeen'])->name('chat.seen');
});