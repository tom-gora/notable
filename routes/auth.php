<?php

use App\Http\Controllers\Auth\VerifyEmailController as Vec;
use App\Notable\Routes\Auth as A;
use App\Notable\Routes\Guest as G;
use Illuminate\Support\Facades\Route as Rt;

Rt::middleware('guest')->group(function () {
    Rt::get('/register', G\Register::class)->name('register');
    Rt::get('/login', G\Login::class)->name('login');
    Rt::get('/forgot-password', G\ForgotPassword::class)->name('forgot-password');
    Rt::get('/reset-password/{token}', G\ResetPassword::class)->name('password.reset');
});

Rt::middleware('auth')->group(function () {
    Rt::get('/verify-email', A\CoreUser\VerifyEmail::class)->name('verification.notice');
    Rt::get('verify-email/{id}/{hash}', Vec::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Rt::get('/confirm-password', A\CoreUser\ConfirmPassword::class)->name('password.confirm');
    Rt::get('/settings', A\CoreUser\Settings::class)->name('settings');
    Rt::get('/profile', A\CoreUser\Profile::class)->name('profile')->middleware(['verified']);

    // functional parts of the app enclosed behind auth AND verificaation
    Rt::get('/home', A\CoreNotes\Home::class)->name('home')->middleware(['verified']);
    Rt::get('/transcripts', A\CoreNotes\Transcripts::class)->name('transcripts')->middleware(['verified']);
    Rt::get('/archive', A\CoreNotes\Archive::class)->name('archive')->middleware(['verified']);
    Rt::get('/favourites', A\CoreNotes\Favourites::class)->name('favourites')->middleware(['verified']);
    Rt::get('/snapshots', A\CoreNotes\Snapshots::class)->name('snapshots')->middleware(['verified']);
});
