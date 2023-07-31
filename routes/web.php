<?php

use App\Http\Controllers\AdminBrandController;
use App\Http\Controllers\AdminCategoryPostController;
use App\Http\Controllers\AdminCategoryProductController;
use App\Http\Controllers\AdminColorController;
use App\Http\Controllers\AdminConfigurationController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AdminPermissionController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminSliderController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'home'])->name('home');
Route::get('/danh-muc/{slug}', [IndexController::class, 'category_product'])->name('product.category');
Route::get('/san-pham/{slug}', [IndexController::class, 'detail'])->name('product.detail');
Route::get('/tim-kiem', [IndexController::class, 'product_search'])->name('product.search');
Route::get('/tin-tuc', [IndexController::class, 'post'])->name('tin-tuc');
Route::get('/tin-tuc/tim-kiem', [IndexController::class, 'post_search'])->name('post.search');
Route::get('/tin-tuc-{slug}', [IndexController::class, 'category_post'])->name('post.category');
Route::get('/tin-tuc/{slug}', [IndexController::class, 'detail_post'])->name('post.detail');
Route::get('ajax/product__search', [AjaxController::class, 'product__search']);
Auth::routes();
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware('auth')->name('admin');
Route::get('/admin', [DashboardController::class, 'dashboard'])->middleware('auth');
Route::get('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('cart/remove/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('cart/load_distric', [CartController::class, 'load_distric']);
Route::get('cart/load_ward', [CartController::class, 'load_ward']);
Route::get('gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::get('thanh-toan', [CartController::class, 'pay'])->name('cart.pay');
Route::get('chi-tiet-don-hang-{id}', [OrderController::class, 'success'])->name('order.success');
Route::post('order/add', [OrderController::class, 'add'])->name('order.add');
Route::get('{slug}', [IndexController::class, 'page'])->name('page');


Route::prefix('admin')->middleware('auth')->group(function () {
    // User
    Route::resource('user', AdminUserController::class);
    Route::post('user/action', [AdminUserController::class, 'action'])->name('user.action');
    Route::get('user/force_delete/{id}', [AdminUserController::class, 'force_delete'])->name('user.force_delele');
    Route::get('user/delete/{id}', [AdminUserController::class, 'delete'])->name('user.delete');
    Route::get('user/restore/{id}', [AdminUserController::class, 'restore'])->name('user.restore');
    // Category Product
    Route::resource('cat_product', AdminCategoryProductController::class);
    Route::get('ajax/edit_cat_product', [AjaxController::class, 'edit_cat_product'])->name('admin.edit_cat_product');
    Route::post('ajax/update_cat_product', [AjaxController::class, 'update_cat_product'])->name('admin.update_cat_product');
    // Brand Product
    Route::resource('brand', AdminBrandController::class);
    Route::get('/ajax/edit_brand', [AjaxController::class, 'edit_brand']);
    Route::post('/ajax/update_brand', [AjaxController::class, 'update_brand']);
    // Color Product
    Route::resource('color', AdminColorController::class);
    Route::get('/ajax/edit_color_product', [AjaxController::class, 'edit_color']);
    Route::post('/ajax/update_color_product', [AjaxController::class, 'update_color']);
    // CONFIGURATION PRODUCT
    Route::get('/configuration', [AdminConfigurationController::class, 'index'])->name('configuration.index');
    Route::post('/configuration/type_store', [AdminConfigurationController::class, 'type_store'])->name('configuration_type.store');
    Route::post('/configuration/detail_store', [AdminConfigurationController::class, 'detail_store'])->name('configuration_detail.store');
    Route::delete('/configuration/type_destroy/{id}', [AdminConfigurationController::class, 'type_destroy'])->name('configuration_type.destroy');
    Route::delete('/configuration/detail_destroy/{id}', [AdminConfigurationController::class, 'detail_destroy'])->name('configuration_detail.destroy');
    Route::get('ajax/update_title_type', [AjaxController::class, 'update_title_type']);
    Route::get('ajax/update_status_type', [AjaxController::class, 'update_status_type']);
    Route::get('ajax/update_title_detail', [AjaxController::class, 'update_title_detail']);
    Route::get('ajax/update_status_detail', [AjaxController::class, 'update_status_detail']);
    Route::get('ajax/update_type_id_detail', [AjaxController::class, 'update_type_id_detail']);
    //ADMIN PRODUCT
    Route::resource('product', AdminProductController::class);
    Route::get('ajax/product_config', [AjaxController::class, 'product_config']);
    Route::get('ajax/delele_img', [AjaxController::class, 'delele_img']);
    Route::post('product/action_product', [AdminProductController::class, 'action'])->name('product.action');
    Route::get('product/delete/{id}', [AdminProductController::class, 'delete'])->name('product.delete');
    // ADMIN POST
    Route::resource('post', AdminPostController::class);
    Route::resource('post_cat', AdminCategoryPostController::class);
    Route::get('post/delete/{id}', [AdminPostController::class, 'delete'])->name('post.delete');
    Route::get('ajax/edit_cat_post', [AjaxController::class, 'edit_cat_post']);
    Route::post('ajax/update_cat_post', [AjaxController::class, 'update_cat_post']);
    Route::post('post/action_post', [AdminPostController::class, 'action'])->name('post.action');
    // ADMIN PAGE
    Route::resource('page', AdminPageController::class);
    Route::get('page/delete/{id}', [AdminPageController::class, 'delete'])->name('page.delete');
    Route::post('page/action_post', [AdminPageController::class, 'action'])->name('page.action');
    // ADMIN ORDER
    Route::get('order', [AdminOrderController::class, 'index'])->name('admin.order');
    Route::get('order/delete/{id}', [AdminOrderController::class, 'delete'])->name('admin.order.delete');
    Route::get('order/{id}', [AdminOrderController::class, 'detail'])->name('admin.order.detail');
    Route::post('order/action', [AdminOrderController::class, 'action'])->name('admin.order.action');
    Route::post('order/update/{id}', [AdminOrderController::class, 'update'])->name('admin.order.update');
    // ADMIN SLIDER
    Route::resource('slider', AdminSliderController::class);
    Route::get('slider/delete/{id}', [AdminSliderController::class, 'delete'])->name('slider.delete');
    Route::post('slider/action', [AdminSliderController::class, 'action'])->name('slider.action');
    // ADMIN PERMISSION
    Route::get('permission/add', [AdminPermissionController::class, 'add'])->name('permission.add');
    Route::get('permission/edit/{id}', [AdminPermissionController::class, 'edit'])->name('permission.edit');
    Route::post('permission/store', [AdminPermissionController::class, 'store'])->name('permission.store');
    Route::post('permission/update/{id}', [AdminPermissionController::class, 'update'])->name('permission.update');
    Route::get('permission/delete/{id}', [AdminPermissionController::class, 'delete'])->name('permission.delete');
    // ADMIN ROLE
    Route::resource('role', AdminRoleController::class);
    Route::get('role/delete/{id}', [AdminRoleController::class, 'delete'])->name('role.delete');
});
