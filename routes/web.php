<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;

Route::view('/', 'welcome')->name('home');
Route::get('/beranda', function () {
    return view('user.beranda');
});
Route::get('/tentang', function () {
    return view('user.tentang');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('admin', 'dashboard')->name('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::resource('/admin/users', UserController::class);
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/articles', ArticleController::class);

});

require __DIR__.'/settings.php';
