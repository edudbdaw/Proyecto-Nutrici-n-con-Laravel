<?php

use App\Http\Controllers\DishController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard');

// Esta ruta ahora solo carga la vista dashboard limpia
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('products', ProductController::class);
});

Route::resource('dishes', DishController::class);

// Rutas manuales para los ingredientes
Route::post('/dishes/{dish}/add-product', [DishController::class, 'addProduct'])->name('dishes.add-product');
Route::delete('/dishes/{dish}/remove-product/{product}', [DishController::class, 'removeProduct'])->name('dishes.remove-product');
Route::resource('menus', MenuController::class)->only(['index', 'create', 'store', 'destroy']);
require __DIR__ . '/auth.php';
