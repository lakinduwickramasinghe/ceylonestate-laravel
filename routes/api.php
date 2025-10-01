<?php

use App\Http\Controllers\api\ChatController;
use App\Http\Controllers\api\FeedbackController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PropertyAdController;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('property', PropertyAdController::class);
    Route::get('property/member/{id}',[PropertyAdController::class,'member_property'])->name('member.properties');
    Route::post('/property/create', [PropertyAdController::class, 'store']);

    Route::apiResource('user', UserController::class);

    Route::apiResource('feedback', FeedbackController::class);

    Route::get('user/{id}', [UserController::class, 'info'])->name('user.info');

    Route::get('feedback/member/{id}', [FeedbackController::class, 'member']);
    
});

Route::get('/properties',[PropertyAdController::class,'all']);
Route::get('/properties/{id}',[PropertyAdController::class,'viewone']);

