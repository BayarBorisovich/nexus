<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Image\ImageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes (без авторизации)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Protected routes (требуется авторизация)
Route::middleware('auth')->group(function () {
    // Home
    Route::get('/', function () {
        return Inertia::render('Home');
    })->name('home');

    // Profile routes (основные данные профиля)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Image routes (загрузка медиа) - ОТДЕЛЬНО
    Route::post('/avatar', [ImageController::class, 'uploadAvatar'])->name('avatar.upload');
    Route::delete('/avatar', [ImageController::class, 'deleteAvatar'])->name('avatar.delete');
    Route::post('/image', [ImageController::class, 'uploadPostImage'])->name('image.upload');
    Route::delete('/image', [ImageController::class, 'deleteImage'])->name('image.delete');

    // Auth
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
