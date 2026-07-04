<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Livewire\Admin\Admins\Index as AdminsIndex;
use App\Livewire\Admin\Categories\Index as CategoriesIndex;
use App\Livewire\Admin\Coupons\Index as CouponsIndex;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\FoodItems\Index as FoodItemsIndex;
use App\Livewire\Admin\Orders\Index as OrdersIndex;
use Illuminate\Support\Facades\Route;

// Customer-facing PWA shell (Blade + Alpine.js single page, calls /api/*)
Route::get('/', function () {
    return view('pwa.index');
})->name('home');

// Admin auth
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin panel (all authenticated admins, role checks below per-section)
Route::middleware('admin.role')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});

Route::middleware('admin.role:Super Admin,Menu Manager')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/categories', CategoriesIndex::class)->name('categories');
    Route::get('/food-items', FoodItemsIndex::class)->name('food-items');
});

Route::middleware('admin.role:Super Admin,Order Manager')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', OrdersIndex::class)->name('orders');
});

Route::middleware('admin.role:Super Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/coupons', CouponsIndex::class)->name('coupons');
    Route::get('/admins', AdminsIndex::class)->name('admins');
});
