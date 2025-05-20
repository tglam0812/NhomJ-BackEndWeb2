<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CrudProductsController;
use App\Http\Controllers\Admin\CrudCategoryController;
use App\Http\Controllers\Admin\CrudAccountAdminController;
use App\Http\Controllers\Admin\CrudLevelController;
use App\Http\Controllers\Admin\CrudSupplierController;
use App\Http\Controllers\Admin\ContactManageController;
use App\Http\Controllers\TrangChuController;
use App\Http\Controllers\PhieuGiamGiaController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ContactController;

// Trang chủ và About
Route::get('/', [TrangChuController::class, 'home'])->name('home');
Route::get('/about', [TrangChuController::class, 'about'])->name('about');

// Trang hiển thị sản phẩm cho người dùng
Route::get('/shop', [TrangChuController::class, 'listProductIndex'])->name('products.shop');

// Chi tiết sản phẩm
Route::get('/product/{product_id}', [TrangChuController::class, 'detailProduct'])->name('product.detail');

// Đăng nhập
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');

// Đăng ký
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.post');

// Đăng xuất
Route::get('logout', [LoginController::class, 'logout'])->name('logout.get');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Thông tin người dùng (bắt buộc đăng nhập)
Route::group(['prefix' => 'auth', 'middleware' => ['auth']], function () {
    Route::get('/info', [InformationController::class, 'info'])->name('auth.info');
    Route::patch('/info/{user_id}', [InformationController::class, 'update'])->name('info.update');
    Route::get('/resetpassword', [InformationController::class, 'showresetpassword'])->name('auth.showresetpassword');
    Route::patch('/resetpassword/{user_id}', [InformationController::class, 'resetpassword'])->name('info.resetpassword');
});

// CRUD Sản phẩm (admin)
Route::prefix('products')->group(function () {
    Route::get('/', [CrudProductsController::class, 'listProduct'])->name('products.list');
    Route::get('/create', [CrudProductsController::class, 'createProduct'])->name('products.createProduct');
    Route::post('/create', [CrudProductsController::class, 'postProduct'])->name('products.postProduct');
    Route::get('/{id}/edit', [CrudProductsController::class, 'updateProduct'])->name('products.updateProduct');
    Route::post('/{id}/edit', [CrudProductsController::class, 'postUpdateProduct'])->name('products.postUpdateProduct');
    Route::get('/{id}', [CrudProductsController::class, 'readProduct'])->name('products.readProduct');
    Route::delete('/{id}', [CrudProductsController::class, 'deleteProduct'])->name('products.deleteProduct');
    Route::delete('/products/{id}', [CrudProductsController::class, 'deleteProduct'])->name('products.delete');
    
});

// CRUD Danh mục
Route::prefix('categories')->group(function () {
    Route::get('/', [CrudCategoryController::class, 'listCategory'])->name('categories.list');
    Route::get('/create', [CrudCategoryController::class, 'createCategory'])->name('categories.createCategory');
    Route::post('/create', [CrudCategoryController::class, 'postCategory'])->name('categories.store');
    Route::get('/{category_id}/edit', [CrudCategoryController::class, 'updateCategory'])->name('categories.updateCategory');
    Route::put('/{category_id}/update', [CrudCategoryController::class, 'postUpdateCategory'])->name('categories.update');
    Route::get('/{category_id}', [CrudCategoryController::class, 'readCategory'])->name('categories.readCategory');
    Route::delete('/{category_id}', [CrudCategoryController::class, 'deleteCategory'])->name('categories.deleteCategory');
});

// CRUD Tài khoản Admin
Route::prefix('accounts')->group(function () {
    Route::get('/', [CrudAccountAdminController::class, 'listAccountAdmin'])->name('accountAdmin.list');
    Route::get('/create', [CrudAccountAdminController::class, 'createAccountAdmin'])->name('accountAdmin.create');
    Route::post('/create', [CrudAccountAdminController::class, 'postAccountAdmin'])->name('accountAdmin.store');
    Route::get('/{account_id}/edit', [CrudAccountAdminController::class, 'updateAccountAdmin'])->name('accountAdmin.update');
    Route::post('/{account_id}/edit', [CrudAccountAdminController::class, 'postUpdateAccountAdmin'])->name('accountAdmin.postUpdate');
    Route::get('/{account_id}', [CrudAccountAdminController::class, 'readAccountAdmin'])->name('accountAdmin.read');
    Route::delete('/{account_id}', [CrudAccountAdminController::class, 'deleteAccountAdmin'])->name('accountAdmin.delete');
});

// CRUD Nhà cung cấp
Route::prefix('suppliers')->group(function () {
    Route::get('/', [CrudSupplierController::class, 'listSupplier'])->name('suppliers.list');
    Route::get('/create', [CrudSupplierController::class, 'createSupplier'])->name('suppliers.createSupplier');
    Route::post('/create', [CrudSupplierController::class, 'postSupplier'])->name('suppliers.store');
    Route::get('/{supplier_id}/edit', [CrudSupplierController::class, 'updateSupplier'])->name('suppliers.updateSupplier');
    Route::put('/{supplier_id}/update', [CrudSupplierController::class, 'postUpdateSupplier'])->name('suppliers.update');
    Route::get('/{supplier_id}', [CrudSupplierController::class, 'readSupplier'])->name('suppliers.readSupplier');
    Route::delete('/{supplier_id}', [CrudSupplierController::class, 'deleteSupplier'])->name('suppliers.deleteSupplier');
});

// CRUD Cấp độ Admin
Route::prefix('levels')->group(function () {
    Route::get('/', [CrudLevelController::class, 'listLevel'])->name('levelAdmin.list');
    Route::get('/create', [CrudLevelController::class, 'createLevel'])->name('levelAdmin.create');
    Route::post('/create', [CrudLevelController::class, 'postLevel'])->name('levelAdmin.store');
    Route::get('/{level_id}/edit', [CrudLevelController::class, 'updateLevel'])->name('levelAdmin.update');
    Route::post('/{level_id}/edit', [CrudLevelController::class, 'postUpdateLevel'])->name('levelAdmin.postUpdate');
    Route::delete('/{level_id}', [CrudLevelController::class, 'deleteLevel'])->name('levelAdmin.delete');
});

// Phiếu giảm giá
Route::resource('phieugiam', PhieuGiamGiaController::class)->parameters([
    'phieugiam' => 'id'
]);

// Wishlist
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product_id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

// Đánh giá
Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store')->middleware('auth');
Route::put('/review/{id}', [ReviewController::class, 'update'])->name('review.update');
Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');

// Giỏ hàng
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

//update giỏ hàng
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

//áp dụng phiếu giảm giá
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');

//loại bỏ phiếu giảm giá
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');

Route::middleware(['auth'])->group(function () {
    // Checkout chỉ cho người đã đăng nhập
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

// Contact - Gửi và xem phản hồi
Route::get('/contact', [TrangChuController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/my-feedbacks', [ContactController::class, 'feedbacks'])->name('feedbacks');

// Admin - Quản lý phản hồi
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/messages', [ContactManageController::class, 'index'])->name('admin.messages');
    Route::post('/messages/{id}/reply', [ContactManageController::class, 'reply'])->name('admin.messages.reply');
});

//

//hiển thị giỏ hàng
Route::get('/order-success', [CheckoutController::class, 'success'])->name('order.success');

