<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use StaticKidz\BedcaAPI\BedcaClient;

//modificamos esta linea para que me lleve al
Route::redirect('/', 'dashboard');

Route::get('/dashboard', function () {

    $client = new BedcaClient();
    $rawDatas = $client->getFoodGroups();

    return view('dashboard' , ['datas' => $rawDatas]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
