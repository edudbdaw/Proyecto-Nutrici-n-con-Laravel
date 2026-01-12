<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use StaticKidz\BedcaAPI\BedcaClient;

//modificamos esta linea para que me lleve al
Route::redirect('/', 'dashboard');

Route::get('/dashboard', function () {
    $client = new BedcaClient();

    // 1. Primero pedimos la lista de productos de la categoría "Frutas" (El ID 5 en Bedca)
    $listaProductos = $client->getFoodGroups();

    

    return view('dashboard', [
        'grupos' => $listaProductos, // Para ver el nombrera ver la info detallada
    ]);

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/* Show all products
    $client = new BedcaClient();
    $rawDatas = $client->getFoodGroups();

    return view('dashboard' , ['datas' => $rawDatas]);
*/ 