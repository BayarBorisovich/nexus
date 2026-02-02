<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/register', [RegisterController::class, 'showRegister'] )->name('register');
Route::post('/register', [RegisterController::class, 'register'] );
Route::get('/login', [LoginController::class, 'showLogin'] )->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/', [MainController::class, 'index'] )->name('main');
Route::get('/profile', [ProfileController::class, 'index'] )->name('profile');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/avatar/upload', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');
Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');

Route::get('/dashboard', function () {
    return Inertia::render('Welcome');
});
