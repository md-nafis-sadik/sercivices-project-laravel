<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminAuthController;
use App\Models\Plan;

Route::get('/', [FrontPageController::class, 'index']);


Route::controller(SocialiteController::class)->group(function () {
    Route::get('auth/google',  'googleLogin')->name('auth.google');
    Route::get('auth/google-callback', 'googleAuthentication')->name('auth.google-callback');

    Route::get('auth/facebook', [SocialiteController::class, 'facebookLogin'])->name('auth.facebook');
Route::get('auth/facebook-callback', [SocialiteController::class, 'facebookAuthentication'])->name('auth.facebook-callback');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employee CRUD routes
    // Route::resource('employees', EmployeeController::class);

    Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
    Route::get('packages/{plan_id}/details', [PackageController::class, 'details'])->name('packages.details');
    Route::get('packages/{plan_id}/payment', [PackageController::class, 'paymentForm'])->name('packages.payment');
    Route::post('packages/{plan_id}/payment', [PackageController::class, 'store'])->name('packages.store');
    Route::get('packages/{order_id}/thank-you', [PackageController::class, 'thankYou'])->name('packages.thankYou');

    Route::get('dashboard/orders/', [PackageController::class, 'userOrders'])->name('packages.userOrders');
    Route::get('dashboard/orders/data', [PackageController::class, 'getUserOrders'])->name('packages.data');

    Route::put('dashboard/orders/{order}', [PackageController::class, 'update'])->name('packages.update');
    Route::get('dashboard/{order}/edit', [PackageController::class, 'edit'])->name('packages.edit');
    Route::put('dashboard/{order}', [PackageController::class, 'update'])->name('packages.update');

});



Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'loginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])
    ->middleware('throttle:admin-login')->name('admin.login.submit');


    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        Route::get('admins', [AdminAuthController::class, 'index'])->name('admin.index');
        Route::get('admins/create', [AdminAuthController::class, 'create'])->name('admin.create');
        Route::post('admins', [AdminAuthController::class, 'store'])->name('admin.store');
        Route::get('admins/{admin}', [AdminAuthController::class, 'show'])->name('admin.show');
        Route::get('admins/{admin}/edit', [AdminAuthController::class, 'edit'])->name('admin.edit');
        Route::put('admins/{admin}', [AdminAuthController::class, 'update'])->name('admin.update');
        Route::delete('admins/{admin}', [AdminAuthController::class, 'destroy'])->name('admin.destroy');
        Route::get('admin/admins/data', [AdminAuthController::class, 'getAdmins'])->name('admin.data');
            // Employee routes
    Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('admin/employees/data', [EmployeeController::class, 'getEmployees'])->name('employees.data');


        // Plan routes
        Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
        Route::get('plans/create', [PlanController::class, 'create'])->name('plans.create');
        Route::post('plans', [PlanController::class, 'store'])->name('plans.store');
        Route::get('plans/{plan}', [PlanController::class, 'show'])->name('plans.show');
        Route::get('plans/{plan}/edit', [PlanController::class, 'edit'])->name('plans.edit');
        Route::put('plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
        Route::delete('plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');
        Route::get('admin/plans/data', [PlanController::class, 'getPlans'])->name('plans.data');

        // Plan routes
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('admin/orders/data', [OrderController::class, 'getOrders'])->name('orders.data');

        // Plan routes
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/create', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::get('payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
        Route::put('payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
        Route::delete('payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
        Route::get('admin/payments/data', [PaymentController::class, 'getPayments'])->name('payments.data');



    });
});



require __DIR__.'/auth.php';
