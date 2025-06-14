<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
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

// VISTA DE PRODUCTOS
Route::get('/productos', function () {
    return Inertia::render('Products/Index');
})->middleware(['auth', 'verified'])->name('productos.vista');

// API PARA OBTENER LOS PRODUCTOS (solo datos)
Route::get('/api/productos', [ProductoController::class, 'index'])->name('productos.api');

// RUTA PARA FORMULARIO DE CREACIÓN
Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');

// POST para guardar productos
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';