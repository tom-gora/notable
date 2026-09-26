<?php

use App\Notable\Routes\Guest as G;
use Illuminate\Support\Facades\Route as Rt;

// logged in user cannot see the generic welcome page inviting to login
// instead take them right to home with custom middleware
Rt::get('/', G\Welcome::class)->name('welcome')->middleware('homeOnAuth');

Rt::get('/note-images/{filename}', function (string $filename) {
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) {
        abort(404);
    }
    $path = storage_path('app/private/note_images/' . $filename);
    if (!is_file($path)) {
        abort(404);
    }
    return response()->file($path);
})->where('filename', '[A-Za-z0-9_]+\.[A-Za-z0-9]+');

require __DIR__ . '/auth.php';
