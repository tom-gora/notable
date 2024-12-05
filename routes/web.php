<?php

use App\Notable\Routes\Guest as G;
use Illuminate\Support\Facades\Route as Rt;

// logged in user cannot see the generic welcome page inviting to login
// instead take them right to home with custom middleware
Rt::get('/', G\Welcome::class)->name('welcome')->middleware('homeOnAuth');

require __DIR__ . '/auth.php';
