<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

Route::get('blogs', [BlogController::class, 'index']);
Route::post('blogs/create', [BlogController::class, 'store']);
// Route::post('create-blog', [BlogController::class, 'store']);
Route::get('blogs/{id}', [BlogController::class, 'show']);
Route::put('blogs/{id}', [BlogController::class, 'update']);
Route::delete('blogs/{id}', [BlogController::class, 'destroy']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
