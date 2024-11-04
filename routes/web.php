<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/settings', function () {
    return view('settings');
});

Route::get('/archive', function () {
    return view('archive');
});

Route::get('/bookmarks', function () {
    return view('bookmarks');
});

Route::get('/collections', function () {
    return view('collections');
});

Route::get('/snapshots', function () {
    return view('snapshots');
});

Route::get('/transcripts', function () {
    return view('transcripts');
});
