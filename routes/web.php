<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipPlanController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\GymClassController;
use App\Http\Controllers\ClassBookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Member\MemberAuthController;
use App\Http\Controllers\Member\MemberPortalController;

// Root → redirect to member login
Route::get('/', function () {
    return redirect()->route('member.login');
});

// ═══════════════════════════════════════════════════════════════════════════
//  ADMIN PANEL  (guard: web / User model)
// ═══════════════════════════════════════════════════════════════════════════

// Admin auth (guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

// Admin protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('members',     MemberController::class);
    Route::resource('plans',       MembershipPlanController::class);
    Route::resource('memberships', MembershipController::class);
    Route::resource('trainers',    TrainerController::class);
    Route::resource('classes',     GymClassController::class);
    Route::resource('bookings',    ClassBookingController::class);
    Route::resource('payments',    PaymentController::class);

    // Admin account management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('admins',                    [AdminController::class, 'index'])->name('admins.index');
        Route::get('admins/create',             [AdminController::class, 'create'])->name('admins.create');
        Route::post('admins',                   [AdminController::class, 'store'])->name('admins.store');
        Route::get('admins/{admin}/edit',       [AdminController::class, 'edit'])->name('admins.edit');
        Route::put('admins/{admin}',            [AdminController::class, 'update'])->name('admins.update');
        Route::delete('admins/{admin}',         [AdminController::class, 'destroy'])->name('admins.destroy');
        Route::get('profile',         [AdminController::class, 'editProfile'])->name('profile');
        Route::post('profile',        [AdminController::class, 'updateProfile'])->name('profile.update');
    });
});

// ═══════════════════════════════════════════════════════════════════════════
//  MEMBER PORTAL  (guard: member / Member model)
// ═══════════════════════════════════════════════════════════════════════════

Route::prefix('member')->name('member.')->group(function () {

    // Guest-only (not logged in as member)
    Route::middleware('member.guest')->group(function () {
        Route::get('login',    [MemberAuthController::class, 'showLogin'])->name('login');
        Route::post('login',   [MemberAuthController::class, 'login'])->name('login.post');
        Route::get('register', [MemberAuthController::class, 'showRegister'])->name('register');
        Route::post('register',[MemberAuthController::class, 'register'])->name('register.post');
    });

    Route::post('logout', [MemberAuthController::class, 'logout'])
        ->middleware('member')->name('logout');

    // Member protected routes
    Route::middleware('member')->group(function () {
        Route::get('dashboard',   [MemberPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('profile',     [MemberPortalController::class, 'profile'])->name('profile');
        Route::put('profile',     [MemberPortalController::class, 'updateProfile'])->name('profile.update');
        Route::put('password',    [MemberPortalController::class, 'updatePassword'])->name('password.update');
        Route::get('memberships', [MemberPortalController::class, 'memberships'])->name('memberships');
        Route::get('classes',     [MemberPortalController::class, 'classes'])->name('classes');
        Route::post('classes/{class}/book',   [MemberPortalController::class, 'bookClass'])->name('classes.book');
        Route::delete('bookings/{booking}/cancel', [MemberPortalController::class, 'cancelBooking'])->name('bookings.cancel');
        Route::get('payments',    [MemberPortalController::class, 'payments'])->name('payments');
        Route::get('payment/pay',    [MemberPortalController::class, 'showPaymentForm'])->name('payment.form');
        Route::post('payment/subscribe', [MemberPortalController::class, 'subscribePlan'])->name('payment.subscribe');
        Route::post('payment/process',   [MemberPortalController::class, 'processPayment'])->name('payment.process');
        Route::get('payment/{payment}/success', [MemberPortalController::class, 'paymentSuccess'])->name('payment.success');
    });
});
