<?php

use App\Http\Controllers\api\ChatController;
use App\Http\Controllers\PropertyAdController;
use App\Http\Controllers\UserController;
use App\Models\PropertyAd;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.landing');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if($role === 'admin'){
            return redirect()->route('admin-db');
        }else{
            return redirect()->route('member-db');
        }
    })->name('dashboard');
});

Route::get('/memberdashboard', function () {
    return view('dashboards.member');
})->middleware('auth')->name('member-db');

Route::resource('property', PropertyAdController::class);

Route::get('/test', function () {
    return view('auth.role-select');
})->name('about');

Route::get('login/admin', function () {
    return view('auth.admin-login');
})->name('login.admin');

Route::get('login/member', function () {
    return view('auth.member-login');
})->name('login.member');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('admin/property',[PropertyAdController::class,'admin_index'])->name('admin.property.index');
    Route::get('admin/property/{id}',[PropertyAdController::class,'admin_view'])->name('admin.property.view');
    Route::get('/admindashboard', function () {
        return view('dashboards.admin');
    })->name('admin-db');

    Route::get('admin/user',[UserController::class,'index'])->name('admin.user.index');
    Route::get('admin/user/{id}',[UserController::class,'show'])->name('admin.user.show');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/chat', [ChatController::class, 'showChatPage'])->name('chat.page');
    Route::get('/chat/{userId}', [ChatController::class, 'openChat'])->name('chat.open');
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.send');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'index'])->name('chat.messages');
    Route::post('/chat/seen/{userId}', [ChatController::class, 'markAsSeen'])->name('chat.seen');
});