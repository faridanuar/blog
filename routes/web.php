<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PlaygroundController;
use App\Http\Controllers\PostCommentsController;

Route::get('/playground', [PlaygroundController::class, 'index'])->name('playground');

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('posts/{post:slug}', [PostController::class, 'show']);
Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);

Route::post('newsletter', NewsletterController::class);

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('login', [SessionsController::class, 'store'])->middleware('guest');

// Auth Section
Route::middleware('auth')->group(function () {
    Route::post('logout', [SessionsController::class, 'destroy']);

    Route::get('profile', [ProfileController::class, 'index']);
    Route::get('profile/edit', [ProfileController::class, 'edit']);
    Route::patch('profile/edit', [ProfileController::class, 'update']);
});

// Admin Section
Route::middleware('can:admin')->group(function () {
    Route::resource('admin/posts', AdminPostController::class)->except('show');
    Route::get('admin/posts/{post:slug}', [AdminPostController::class, 'show']);
});
