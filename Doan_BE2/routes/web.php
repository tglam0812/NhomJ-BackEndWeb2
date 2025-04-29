<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\UserController;
use Illuminate\Support\Facades\Controller;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CrudProductsController;
use App\Http\Controllers\CrudCategoryController;

// Route::get('login', [LoginController::class, 'login'])->name('login');


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::get('/', function () {
    return view('index');
});

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register');

// Products
Route::prefix('products')->group(function () {
    Route::get('/', [CrudProductsController::class, 'listProduct'])->name('products.list');
    Route::get('/create', [CrudProductsController::class, 'createProduct'])->name('products.createProduct');
    Route::post('/create', [CrudProductsController::class, 'postProduct'])->name('products.postProduct');
    Route::get('/{id}/edit', [CrudProductsController::class, 'updateProduct'])->name('products.updateProduct');
    Route::post('/{id}/edit', [CrudProductsController::class, 'postUpdateProduct'])->name('products.postUpdateProduct');
    Route::get('/{id}', [CrudProductsController::class, 'readProduct'])->name('products.readProduct');
    Route::delete('/{id}', [CrudProductsController::class, 'deleteProduct'])->name('products.deleteProduct');
});

// Category
Route::prefix('categories')->group(function () {
    Route::get('/', [CrudCategoryController::class, 'listCategory'])->name('categories.list'); // Danh sách danh mục
    Route::get('/create', [CrudCategoryController::class, 'createCategory'])->name('categories.createCategory'); // Tạo danh mục
    Route::post('/create', [CrudCategoryController::class, 'postCategory'])->name('categories.store'); 
    Route::get('/{category_id}/edit', [CrudCategoryController::class, 'updateCategory'])->name('categories.updateCategory'); 
    Route::put('/{category_id}/update', [CrudCategoryController::class, 'postUpdateCategory'])->name('categories.update'); 
    Route::get('/{category_id}', [CrudCategoryController::class, 'readCategory'])->name('categories.readCategory');
    Route::delete('/{category_id}', [CrudCategoryController::class, 'deleteCategory'])->name('categories.deleteCategory');
});