<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;


Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [Register::class, 'create'])->name('register');
    Route::post('/register', [Register::class, 'store']);

    Route::get('/login', [Login::class, 'create'])->name('login');
    Route::post('/login', [Login::class, 'store']);
});

Route::middleware('auth')->group(function () {

    // Email verification
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('home');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:6,1')->name('verification.send');

    // Logout
    Route::post('/logout', Logout::class)->name('logout');

    // Posts CRUD (edit, update, store, destroy) using slug
    Route::resource('posts', PostController::class)
        ->only(['store', 'edit', 'update', 'destroy'])
        ->parameters(['posts' => 'post:slug']);
});

// User CRUD (auth + verified)
Route::middleware(['auth', 'verified'])->group(function() {
    Route::resource('users', UserController::class);
});