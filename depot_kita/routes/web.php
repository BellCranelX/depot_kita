<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

Route::get('employee/dashboard', [HomeController::class, 'index'])->name('employee.dashboard');

Route::resource('products', ProductsController::class)->names([
    'index' => 'products.index',
    'create' => 'products.create',
    'store' => 'products.store',
    'show' => 'products.show',
    'edit' => 'products.edit',
    'update' => 'products.update',
    'destroy' => 'products.destroy',
]);

Route::resource('transactions', TransactionsController::class)->names([
    'index' => 'transactions.index',
    'create' => 'transactions.create',
    'store' => 'transactions.store',
    'show' => 'transactions.show',
    'edit' => 'transactions.edit',
    'update' => 'transactions.update',
    'destroy' => 'transactions.destroy',
]);

Route::resource('orders', OrdersController::class)->names([
    'index' => 'orders.index',
    'create' => 'orders.create',
    'store' => 'orders.store',
    'show' => 'orders.show',
    'edit' => 'orders.edit',
    'update' => 'orders.update',
    'destroy' => 'orders.destroy',
]);

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
