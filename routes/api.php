<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;

// Blogs Routes
Route::prefix('blogs')->name('blogs.')->group(function () {

    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::post('/create', [BlogController::class, 'store'])->name('store');
    Route::get('/{id}', [BlogController::class, 'show'])->name('show');
    Route::put('/{id}', [BlogController::class, 'update'])->name('update');
    Route::delete('/{id}', [BlogController::class, 'destroy'])->name('destroy');

});

// Categories Routes
Route::prefix('categories')->name('categories.')->group(function () {

    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::post('/create', [CategoryController::class, 'store'])->name('store');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');

});

// Sub Categories Routes
Route::apiResource('sub-categories', SubCategoryController::class);

// Auth User Route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
