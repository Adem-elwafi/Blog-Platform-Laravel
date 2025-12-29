<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts', PostController::class)->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});


Route::get('/admin/dashboard', [AdminController::class, 'index'])
    ->middleware('admin')
    ->name('admin.dashboard');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->middleware('auth');

Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])
    ->middleware('auth')
    ->name('posts.like');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->middleware(['auth', 'rate.limit']);

Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])
    ->middleware(['auth', 'rate.limit']);


require __DIR__.'/auth.php';
