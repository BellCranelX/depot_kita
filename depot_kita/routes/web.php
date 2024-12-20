<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Middleware\EnsureCustomerIsAuthenticated;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/order', function () {
    return view('order');
})->name('order.page');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/checkout', function () {
    return view('checkout');
});



require __DIR__ . '/auth.php';

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

Route::resource('customers', CustomersController::class)->names([
    'index' => 'customers.index',
    'create' => 'customers.create',
    'store' => 'customers.store',
    'show' => 'customers.show',
    'edit' => 'customers.edit',
    'update' => 'customers.update',
    'destroy' => 'customers.destroy',
]);
Route::get('/orders/{order}/edit', [OrdersController::class, 'edit'])->name('orders.edit');


Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');




Route::get('/customer/login', [AuthController::class, 'showLoginForm'])->name('customer.login');
Route::post('/customer/login', [AuthController::class, 'login']);


Route::middleware([EnsureCustomerIsAuthenticated::class])->group(function () {
    Route::get('/customer/order', [AuthController::class, 'order'])->name('customer.order');
});

Route::post('/checkout', [OrdersController::class, 'processCheckout'])->middleware('auth:customer');

Route::post('/order/submit', [OrdersController::class, 'submit'])->name('order.submit');


Route::get('/customer/order', action: [ProductsController::class, 'showMenu'])->name('customer.order');

Route::post('/checkout', [OrdersController::class, 'processCheckout'])->name('checkout');

use App\Http\Controllers\MenuController;

Route::get('/admin/menu', [MenuController::class, 'index'])->name('menus.index');
// Define the route for storing the new product
Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');

Route::delete('/menus/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');



Route::middleware('auth:customer')->group(function () {
    Route::get('/customer/profile', [CustomersController::class, 'profile'])->name('customer.profile');
    // web.php
    Route::post('/customer/logout', [CustomersController::class, 'logout'])->name('customer.logout');
});




Route::get('/register', [CustomersController::class, 'showRegistrationForm'])->name('customer.register');
Route::post('/register', [CustomersController::class, 'register'])->name('customer.register.submit');



Route::get('/customer/checkout', [OrdersController::class, 'checkout'])->name('customer.checkout');



// Success callback route
Route::post('/payment/success', [OrdersController::class, 'success'])->name('payment.success');

// Route to show the order success page
Route::get('/order/success', function () {
    return view('customer.order-success');
})->name('order.success');


Route::post('/orders/{id}/update-status', [OrdersController::class, 'updateStatus']);
