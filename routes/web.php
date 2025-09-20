<?php

use App\Http\Controllers\api\ChatController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PropertyAdController;
use App\Http\Controllers\UserController;
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


Route::get('login/admin', function () {
    return view('auth.admin-login');
})->name('login.admin');

Route::get('login/member', function () {
    return view('auth.member-login');
})->name('login.member');

Route::get('aboutus', function () {
    return view('home.aboutus');
})->name('aboutus');

Route::get('properties', function () {
    return view('home.properties');
})->name('properties');

Route::get('feedback/create', function () {
    return view('home.create_feedback');
})->name('feedback.create');



// Admin Web Routes
Route::middleware(['role:admin'])->group(function () {

    Route::get('/admindashboard', function () {
        return view('dashboards.admin');
    })->name('admin-db');

    Route::get('admin/property',[PropertyAdController::class,'admin_index'])->name('admin.property.index');
    Route::get('admin/property/{id}',[PropertyAdController::class,'admin_view'])->name('admin.property.view');
    Route::get('/admin/property/{id}',[PropertyAdController::class,'admin_view'])->name('admin.property.view');
    
    Route::get('admin/user',[UserController::class,'index'])->name('admin.user.index');
    Route::get('admin/user/{id}',[UserController::class,'show'])->name('admin.user.show');

    Route::get('admin/feedback', [FeedbackController::class, 'admin_index'])->name('admin.feedback.index');
    Route::get('admin/feedback/{id}', [FeedbackController::class, 'admin_view'])->name('admin.feedback.view');
});



// Member Web Routes
Route::middleware(['role:member'])->group(function () {

    Route::get('/memberdashboard', function () {
        return view('dashboards.member');
    })->name('member-db');

    Route::get('feedback/{id}', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::resource('feedback', FeedbackController::class)->except(['index','create','show']);
    Route::get('feedback/show/{id}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::resource('property', PropertyAdController::class);

});


Route::middleware(['role:admin,member'])->group(function () {

    Route::get('/chat', [ChatController::class, 'showChatPage'])->name('chat.page');
    Route::get('/chat/{userId}', [ChatController::class, 'openChat'])->name('chat.open');
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.send');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'index'])->name('chat.messages');
    Route::post('/chat/seen/{userId}', [ChatController::class, 'markAsSeen'])->name('chat.seen');
});