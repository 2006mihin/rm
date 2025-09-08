<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public landing page
Route::get('/', function () {
    return view('welcome');
});

// Public home page (guests + logged-in users can see)
Route::get('/home', function () {
    return view('home');
})->name('home');

// Public pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/rings', function () {
    return view('rings');
})->name('rings');

Route::get('/pendants', function () {
    return view('pendants');
})->name('pendants');

Route::get('/earrings', function () {
    return view('earrings');
})->name('earrings');

Route::get('/bracelets', function () {
    return view('bracelets');
})->name('bracelets');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Jetstream always expects a "dashboard" route
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user && $user->role !== 'admin') {
            return redirect()->route('home'); // clients to home
        }

        return redirect()->route('admin.dashboard'); // just in case admin hits here
    })->name('dashboard');

    // Cart and checkout require login
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
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


    Route::get('/about', function () {
        return view('about');
    })->name('about');
});
