<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route untuk 'index' dan 'show' yang boleh diakses publik
Route::resource('posts', PostController::class)
    ->only(['index', 'show'])
    ->names([
        'index' => 'posts.index',
        'show' => 'posts.show',
    ]);

// Route untuk 'store', 'update', dan 'destroy' yang butuh auth
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('posts', PostController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store' => 'posts.store',
            'update' => 'posts.update',
            'destroy' => 'posts.destroy',
        ]);
});
