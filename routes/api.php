<?php

use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/status' , function (){
   return response()->json([
    'status' => 'ok',
    'laravel' => app()->version(),
   ]) ;
});

Route::apiResource('Product' , ApiProductController::class);
Route::post('/login', [UserController::class , 'index']);