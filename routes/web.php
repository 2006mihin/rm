<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;

// Public landing page
Route::get('/', function () {
    return view('welcome');
});

// Normal user home (after login)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // This route exists because Jetstream/redirect expects 'dashboard'
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // If client, redirect to /home
        if ($user && $user->role !== 'admin') {
            return redirect()->route('home');
        }

        // If somehow admin ends up here, redirect to admin dashboard
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    // Home page for clients
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});

// Admin-only dashboard & pages
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin', // custom admin middleware
])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Products & Orders pages
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');

    // Users CRUD
    Route::get('/users', [UserController::class,'index'])->name('users.index');
    Route::post('/users', [UserController::class,'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class,'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class,'destroy'])->name('users.destroy');
});
