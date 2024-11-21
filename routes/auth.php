<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Notable as N;

Route::middleware('guest')->group(function () {
    Route::get('/register', N\Register::class)
        ->name('register');

    Route::get('/login', N\Login::class)
        ->name('login');

    Route::get('/forgot-password', N\ForgotPassword::class)
        ->name('forgot-password');

    Route::get('/reset-password/{token}', N\ResetPassword::class)
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('/verify-email', N\VerifyEmail::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::get('/confirm-password', N\ConfirmPassword::class)
        ->name('password.confirm');
});
