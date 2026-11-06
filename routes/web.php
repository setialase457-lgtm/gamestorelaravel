

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerAuthController;

// HALAMAN UTAMA GAMESTORE
Route::get('/', function () {
    return view('welcome');
})->name('home');

// LOGIN ADMIN
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// HALAMAN ADMIN
Route::middleware([AdminMiddleware::class])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // PESANAN
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{id}', [OrderController::class, 'show'])
        ->whereNumber('id')
        ->name('orders.show');

    Route::patch('/orders/{id}', [OrderController::class, 'update'])
        ->whereNumber('id')
        ->name('orders.update');

    // PENGGUNA
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::patch('/users/{id}/role', [UserController::class, 'updateRole'])
        ->whereNumber('id')
        ->name('users.role');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])
        ->whereNumber('id')
        ->name('users.destroy');

    // PEMBAYARAN
    Route::get('/payments', [PaymentController::class, 'index'])
        ->name('payments.index');

    Route::patch('/payments/{id}', [PaymentController::class, 'update'])
        ->whereNumber('id')
        ->name('payments.update');

    // PRODUK
    Route::resource('products', ProductController::class)
        ->except(['show']);

    // PENGATURAN ADMIN
    Route::get('/admin/settings', [AdminSettingsController::class, 'edit'])
        ->name('admin.settings');

    Route::put('/admin/settings', [AdminSettingsController::class, 'update'])
        ->name('admin.settings.update');
});

// LOGIN CUSTOMER
Route::get('/customer/login', [CustomerAuthController::class, 'showLogin'])
    ->name('customer.login');

Route::post('/customer/login', [CustomerAuthController::class, 'login'])
    ->name('customer.login.submit');

// REGISTER CUSTOMER
Route::get('/customer/register', [CustomerAuthController::class, 'showRegister'])
    ->name('customer.register');

Route::post('/customer/register', [CustomerAuthController::class, 'register'])
    ->name('customer.register.submit');

// DASHBOARD CUSTOMER
Route::middleware('customer')->prefix('customer')->name('customer.')->group(function () {

    Route::get('/dashboard', [CustomerAuthController::class, 'dashboard'])
        ->name('dashboard');

    Route::post('/logout', [CustomerAuthController::class, 'logout'])
        ->name('logout');

});
