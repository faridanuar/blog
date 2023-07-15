<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PlaygroundController;
use App\Http\Controllers\PostCommentsController;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('posts/{post:slug}', [PostController::class, 'show']);

Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);

Route::post('newsletter', NewsletterController::class);

Route::get('playground', [PlaygroundController::class, 'index'])->name('playground');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create']);
    Route::post('register', [RegisterController::class, 'store']);

    Route::get('login', [SessionsController::class, 'create'])->name('login');
    Route::post('login', [SessionsController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [SessionsController::class, 'destroy']);

    Route::get('profile', [ProfileController::class, 'index']);
    Route::get('profile/edit', [ProfileController::class, 'edit']);
    Route::patch('profile/edit', [ProfileController::class, 'update']);
});

Route::resource('dashboard/users', \App\Http\Controllers\Dashboard\UserController::class);
Route::resource('dashboard/posts', \App\Http\Controllers\Dashboard\PostController::class);
