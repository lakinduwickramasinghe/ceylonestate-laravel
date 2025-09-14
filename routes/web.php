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

Route::get('/admindashboard', function () {
    return view('dashboards.admin');
})->middleware('auth')->name('admin-db');

Route::get('/memberdashboard', function () {
    return view('dashboards.member');
})->middleware('auth')->name('member-db');


Route::resource('property', PropertyAdController::class);
Route::get('admin/properties',[PropertyAdController::class,'admin_index'])->name('admin.property.index');
Route::get('admin/propery/{id}',[PropertyAdController::class,'admin_view'])->name('admin.property.view');