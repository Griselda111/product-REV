<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\MemberJasaController;
use App\Http\Controllers\MemberCustomerController;
use App\Http\Controllers\MemberOrderController;
use App\Models\Order;

///////////////// MEMBER //////////////////

Route::get('/', function () {
    return view('welcome.welcome');
})->name('home');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/verify-otp', function () {
    if (!session()->has('otp_email')) {
        return redirect()->route('register');
    }
    return view('verifyOTP.verifyotp');
})->name('verify.otp.page');

Route::get('/dashboard', [MemberDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

//form action login
Route::post('/login', [UserController::class, 'loginweb'])->name('loginweb');
//form action register
Route::post('/register', [UserController::class, 'register'])->name('register.store');

//form action verify otp
Route::post('/verify-otp', [OtpController::class, 'verifyOtpweb'])->name('verify.otp');    
//resend otp
Route::post('/resend-otp', [OtpController::class, 'sendOtp'])->middleware('throttle:3,1')->name('resend.otp');


Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update');

// halaman reset password
Route::get('/resetpassword', function () {
    return view('PassReset.resetPass');
})->name('password.request');

// kirim email reset password
Route::post('/resetpassword/send', [ForgotPasswordController::class, 'sendResetLink'])
    ->middleware('throttle:3,1')
    ->name('password.reset.link');

// link dari email
Route::get('/resetpassword/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

// submit password baru
Route::post('/resetpassword/reset', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.reset.submit');

//logout
Route::post('/logout', [UserController::class, 'logoutweb'])
    ->name('logout')
    ->middleware('auth');

///////////////// MEMBER //////////////////

// Protected member area
Route::middleware('auth')->group(function () {
    // Biaya Jasa (read-only)
    Route::get('/biaya-jasa', [MemberJasaController::class, 'index'])
        ->name('BiayaJasa.index');

    // Customer (read-only)
    Route::get('/customers', [MemberCustomerController::class, 'index'])
        ->name('customers.index');

    // Order (read-only)
    Route::get('/orders', [MemberOrderController::class, 'index'])
        ->name('orders.index');

    // Profil member
    Route::get('/profile', [UserController::class, 'editProfileMember'])
        ->name('member.profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfileMember'])
        ->name('member.profile.update');
});

///////////////// ADMIN //////////////////
Route::get('/admin/login', function () {
    return view('admin.auth.adminlogin');
})->name('admin.login');

Route::post('/admin/login', [UserController::class, 'loginAdmin'])->name('admin.login.post');


Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $belum = Order::where('status_produksi', 1)->count();
        $proses = Order::where('status_produksi', 2)->count();
        $selesai = Order::where('status_produksi', 3)->count();

        return view('admin.dashboard', compact('belum', 'proses', 'selesai'));
    })->name('admin.dashboard');

    // gunakan path berbeda agar tidak menimpa route logout member
    Route::post('/admin/logout', [UserController::class, 'logoutAdmin'])
    ->name('logoutadmin')
    ->middleware('auth');

    // User Management Routes
    Route::get('/admin/users', [UserController::class, 'show'])->name('admin.users.index');

    // Profil admin (self)
    Route::get('/admin/profile', [UserController::class, 'editProfileAdmin'])->name('admin.profile.edit');
    Route::put('/admin/profile', [UserController::class, 'updateProfileAdmin'])->name('admin.profile.update');

    //untuk promote dan demote user//
     Route::post('/users/{id}/promote', [UserController::class, 'promote'])
        ->name('admin.users.promote');

    Route::post('/users/{id}/demote', [UserController::class, 'demote'])
        ->name('admin.users.demote');
    //route promote & demote user berakhir disini//
    // Delete User Route
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])
        ->name('admin.users.delete');

    // Biaya Jasa
    Route::get('/admin/biaya-jasa', [JasaController::class, 'index'])
        ->name('admin.BiayaJasa.index');
    Route::post('/admin/biaya-jasa', [JasaController::class, 'store'])
        ->name('admin.BiayaJasa.store');
    Route::put('/admin/biaya-jasa/{jasa}', [JasaController::class, 'update'])
        ->name('admin.BiayaJasa.update');
    Route::delete('/admin/biaya-jasa/{jasa}', [JasaController::class, 'destroy'])
        ->name('admin.BiayaJasa.destroy');

    // Customer
    Route::get('/admin/customers', [CustomerController::class, 'index'])
        ->name('admin.customers.index');
    Route::post('/admin/customers', [CustomerController::class, 'store'])
        ->name('admin.customers.store');
    Route::put('/admin/customers/{customer}', [CustomerController::class, 'update'])
        ->name('admin.customers.update');
    Route::delete('/admin/customers/{customer}', [CustomerController::class, 'destroy'])
        ->name('admin.customers.destroy');

    // Order
    Route::get('/admin/orders', [OrderController::class, 'index'])
        ->name('admin.orders.index');
    Route::post('/admin/orders', [OrderController::class, 'store'])
        ->name('admin.orders.store');
    Route::put('/admin/orders/{order}', [OrderController::class, 'update'])
        ->name('admin.orders.update');
    Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])
        ->name('admin.orders.destroy');
    
});
