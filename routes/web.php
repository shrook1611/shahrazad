<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\sessionController;
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