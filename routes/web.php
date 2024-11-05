<?php

use App\Notable as N;
use Illuminate\Support\Facades\Route as Rt;

Rt::get('/', N\Home::class)->name('home');
Rt::get('/transcripts', N\Transcripts::class)->name('transcripts');
Rt::get('/archive', N\Archive::class)->name('archive');
Rt::get('/bookmarks', N\Bookmarks::class)->name('bookmarks');
Rt::get('/collections', N\Collections::class)->name('collections');
Rt::get('/settings', N\Settings::class)->name('settings');
Rt::get('/snapshots', N\Snapshots::class)->name('snapshots');


Rt::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*Rt::view('profile', 'livewire.profile')*/
Rt::get('/profile', N\Profile::class)->name('profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
