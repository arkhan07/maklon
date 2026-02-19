<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LegalitasController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// Root → redirect
Route::get('/', fn() => redirect()->route('login'));

// ─── Guest Only ────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

// Google OAuth placeholder
Route::get('/auth/google', fn() => redirect()->route('login')->with('status', 'Google login belum dikonfigurasi.'))->name('auth.google');

// ─── Authenticated (User) ──────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/invoices/{invoice}/pay', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/invoices/{invoice}/pay', [PaymentController::class, 'store'])->name('payments.store');

    Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/layanan/legalitas', [LegalitasController::class, 'index'])->name('layanan.legalitas');
});

// ─── Admin Only ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{order}/invoice', [Admin\OrderController::class, 'createInvoice'])->name('orders.invoice');

    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}/toggle', [Admin\UserController::class, 'toggleStatus'])->name('users.toggle');

    Route::get('/invoices', [Admin\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [Admin\InvoiceController::class, 'show'])->name('invoices.show');
    Route::put('/invoices/{invoice}/status', [Admin\InvoiceController::class, 'updateStatus'])->name('invoices.status');

    Route::get('/payments', [Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::put('/payments/{payment}/verify', [Admin\PaymentController::class, 'verify'])->name('payments.verify');

    Route::get('/settings', [Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/password', [Admin\SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/admin', [Admin\SettingsController::class, 'addAdmin'])->name('settings.add_admin');
});
