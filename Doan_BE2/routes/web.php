<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CrudProductsController;
use App\Http\Controllers\Admin\CrudCategoryController;
use App\Http\Controllers\Admin\CrudAccountAdminController;
use App\Http\Controllers\Admin\CrudLevelController;
use App\Http\Controllers\TrangChuController;
use App\Http\Controllers\PhieuGiamGiaController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\Admin\CrudSupplierController;

// Route::get('login', [LoginController::class, 'login'])->name('login');

Route::get('/', [TrangChuController::class, 'home'])->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');

// Route::get('/', function () {
//     return view('index');
// });

// Trang chủ (hiển thị sản phẩm mới)
Route::get('/', [TrangChuController::class, 'home'])->name('home');

// Đăng ký
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.post');

// Đăng xuất
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Thông tin người dùng
Route::group(['prefix' => 'auth', 'middleware' => ['auth']], function () {
    Route::get('/info', [InformationController::class, 'info'])->name('auth.info');
    Route::patch('/info/{user_id}', [InformationController::class, 'update'])->name('info.update');
    Route::get('/resetpassword', [InformationController::class, 'showresetpassword'])->name('auth.showresetpassword');
    Route::patch('/resetpassword/{user_id}', [InformationController::class, 'resetpassword'])->name('info.resetpassword');
});

// Products Admin
Route::prefix('products')->group(function () {
    Route::get('/', [CrudProductsController::class, 'listProduct'])->name('products.list');
    Route::get('/create', [CrudProductsController::class, 'createProduct'])->name('products.createProduct');
    Route::post('/create', [CrudProductsController::class, 'postProduct'])->name('products.postProduct');
    Route::get('/{id}/edit', [CrudProductsController::class, 'updateProduct'])->name('products.updateProduct');
    Route::post('/{id}/edit', [CrudProductsController::class, 'postUpdateProduct'])->name('products.postUpdateProduct');
    Route::get('/{id}', [CrudProductsController::class, 'readProduct'])->name('products.readProduct');
    Route::delete('/{id}', [CrudProductsController::class, 'deleteProduct'])->name('products.deleteProduct');
});

// Category Admin
Route::prefix('categories')->group(function () {
    Route::get('/', [CrudCategoryController::class, 'listCategory'])->name('categories.list'); // Danh sách danh mục
    Route::get('/create', [CrudCategoryController::class, 'createCategory'])->name('categories.createCategory'); // Tạo danh mục
    Route::post('/create', [CrudCategoryController::class, 'postCategory'])->name('categories.store'); 
    Route::get('/{category_id}/edit', [CrudCategoryController::class, 'updateCategory'])->name('categories.updateCategory'); 
    Route::put('/{category_id}/update', [CrudCategoryController::class, 'postUpdateCategory'])->name('categories.update'); 
    Route::get('/{category_id}', [CrudCategoryController::class, 'readCategory'])->name('categories.readCategory');
    Route::delete('/{category_id}', [CrudCategoryController::class, 'deleteCategory'])->name('categories.deleteCategory');
});

// Account Admin
Route::prefix('accounts')->group(function () {
    Route::get('/', [CrudAccountAdminController::class, 'listAccountAdmin'])->name('accountAdmin.list');
    Route::get('/create', [CrudAccountAdminController::class, 'createAccountAdmin'])->name('accountAdmin.create'); // Tạo danh mục
    Route::post('/create', [CrudAccountAdminController::class, 'postAccountAdmin'])->name('accountAdmin.store'); 
    Route::get('/{account_id}/edit', [CrudAccountAdminController::class, 'updateAccountAdmin'])->name('accountAdmin.update');
    Route::post('/{account_id}/edit', [CrudAccountAdminController::class, 'postUpdateAccountAdmin'])->name('accountAdmin.postUpdate');
    Route::get('/{account_id}', [CrudAccountAdminController::class, 'readAccountAdmin'])->name('accountAdmin.read');
    Route::delete('/{account_id}', [CrudAccountAdminController::class, 'deleteAccountAdmin'])->name('accountAdmin.delete');
});
// crud nhà cung cấp supplier
Route::prefix('suppliers')->group(function () {
    Route::get('/', [CrudSupplierController::class, 'listSupplier'])->name('suppliers.list'); // Danh sách nhà cung cấp
    Route::get('/create', [CrudSupplierController::class, 'createSupplier'])->name('suppliers.createSupplier'); // Tạo nhà cung cấp
    Route::post('/create', [CrudSupplierController::class, 'postSupplier'])->name('suppliers.store'); 
    Route::get('/{supplier_id}/edit', [CrudSupplierController::class, 'updateSupplier'])->name('suppliers.updateSupplier'); // Cập nhật nhà cung cấp
    Route::put('/{supplier_id}/update', [CrudSupplierController::class, 'postUpdateSupplier'])->name('suppliers.update'); 
    Route::get('/{supplier_id}', [CrudSupplierController::class, 'readSupplier'])->name('suppliers.readSupplier');
    Route::delete('/{supplier_id}', [CrudSupplierController::class, 'deleteSupplier'])->name('suppliers.deleteSupplier'); // Xóa nhà cung cấp
});

// Level Admin
Route::prefix('levels')->group(function () {
    Route::get('/', [CrudLevelController::class, 'listLevel'])->name('levelAdmin.list');
    Route::get('/create', [CrudLevelController::class, 'createLevel'])->name('levelAdmin.create');
    Route::post('/create', [CrudLevelController::class, 'postLevel'])->name('levelAdmin.store');
    Route::get('/{level_id}/edit', [CrudLevelController::class, 'updateLevel'])->name('levelAdmin.update');
    Route::post('/{level_id}/edit', [CrudLevelController::class, 'postUpdateLevel'])->name('levelAdmin.postUpdate');
    Route::delete('/{level_id}', [CrudLevelController::class, 'deleteLevel'])->name('levelAdmin.delete');
});




// Danh sách sản phẩm có tìm kiếm (tránh trùng admin)
Route::get('/shop', [TrangChuController::class, 'listProductIndex'])->name('products.shop');

// Chi tiết sản phẩm
Route::get('/product/{product_id}', [TrangChuController::class, 'detailProduct'])->name('product.detail');

// Phiếu giảm giá
Route::resource('phieugiam', PhieuGiamGiaController::class)->parameters([
    'phieugiam' => 'id'
]);

// Sản phẩm yêu thích
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product_id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store')->middleware('auth');
Route::put('/review/{id}', [ReviewController::class, 'update'])->name('review.update');

// Xóa comment
Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');

// Giỏ hàng
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// Chuyển về trang chủ 
Route::get('/index', [TrangChuController::class, 'home'])->name('home');