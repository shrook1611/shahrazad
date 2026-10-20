<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\sessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// home route
Route::get('/home', [HomeController::class, 'index'])->name('home');
// authentication routes
Route::get('/register', [AuthController::class, 'create'])->name('create.register');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');
Route::get('/login', [sessionController::class, 'create'])->name('create.login');
Route::post('/login', [sessionController::class, 'login'])->name('login.store');
Route::post('/logout', [sessionController::class, 'logout'])->name('logout');
// dashboard route
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');
// 
Route::get('/allproducts', function () {
    return view('user.products.allproducts', [
        'allproducts' => \App\Models\Product::all(),
    ]);
})->name('allproducts');

// products
Route::get('/index',[ProductController::class,'index'])->name('product.index');
Route::get('/create',[ProductController::class,'create'])->name('product.create');
Route::post('/store',[ProductController::class,'store'])->name('product.store');
Route::get('/edit/{id}',[ProductController::class,'edit'])->name('product.edit');
Route::post('/update/{id}',[ProductController::class,'update'])->name('product.update');
Route::delete('/delete/{id}',[ProductController::class,'delete'])->name('product.delete');
// categories
Route::get('/category/index',[App\Http\Controllers\CategoryController::class,'index'])->name('category.index');
Route::get('/category/create',[App\Http\Controllers\CategoryController::class,'create'])->name('category.create');
Route::post('/category/store',[App\Http\Controllers\CategoryController::class,'store'])->name('category.store');
// dashboard user routes

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// cart route
Route::post('/cart/addToCart/{id}', [CartController::class, 'addToCart'])->name('addToCart');
// order route
Route::post('/createOrder', [OrderController::class, 'createOrder'])->name('createOrder');
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/allOrders', [OrderController::class, 'index'])->name('allOrders');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/customer-orders/{id}', [OrderController::class, 'showCustomerOrder'])->name('customer-orders.show');

    // Customer's order history
    Route::get('/my-orders', [OrderController::class, 'myOrders'])
        ->name('orders.history');

    // Admin order management
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])
        ->name('admin.orders.index');

    Route::patch('/admin/orders/{id}/status', [
        OrderController::class,
        'updateStatus'
    ])->name('admin.orders.updateStatus');
