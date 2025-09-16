<?php

use App\Http\Controllers\PropertyAdController;
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
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/memberdashboard', function () {
    return view('dashboards.member');
})->middleware('auth')->name('member-db');


Route::resource('property', PropertyAdController::class);


//admin routes
Route::get('admin/properties',[PropertyAdController::class,'admin_index'])->name('admin.property.index');
Route::get('admin/property/{id}',[PropertyAdController::class,'admin_view'])->name('admin.property.view');
Route::get('/admindashboard', function () {
    return view('dashboards.admin');
})->name('admin-db');


Route::get('/test', function () {
    return view('auth.role-select');
})->name('about');


Route::get('login/admin', function () {
    return view('auth.admin-login');
})->name('login.admin');

Route::get('login/member', function () {
    return view('auth.member-login');
})->name('login.member');