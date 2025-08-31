<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public landing page
Route::get('/', function () {
    return view('welcome');
});

// Normal user dashboard (Jetstream default)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Admin-only dashboard & pages
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin', // your custom admin middleware
])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Products & Orders pages
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');

    // Users CRUD
    Route::get('/users', [UserController::class,'index'])->name('users.index');         // Show all users / edit form
    Route::post('/users', [UserController::class,'store'])->name('users.store');        // Add new user
    Route::put('/users/{user}', [UserController::class,'update'])->name('users.update'); // Update user
    Route::delete('/users/{user}', [UserController::class,'destroy'])->name('users.destroy'); // Delete user
});
