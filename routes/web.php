<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleDetailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\TagController;

Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/berita/{slug}', [ArticleDetailController::class, 'show'])->name('articles.detail');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('admin', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::resource('/admin/users', UserController::class);
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/articles', ArticleController::class);
    Route::resource('/admin/tags', TagController::class);

});

require __DIR__.'/settings.php';
