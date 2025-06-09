<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/fancy-login', function () {
    return Inertia::render('auth/FancyLogin');
});

Route::get('/productos/crear', function () {
    return Inertia::render('Products/Create');
});

Route::get('/productos', function () {
    return Inertia::render('Products/Index');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
