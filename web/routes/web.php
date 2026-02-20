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
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\MouController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\SuperAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

// Guest Only
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

Route::get('/auth/google', fn() => redirect()->route('login')->with('status', 'Google login belum dikonfigurasi.'))->name('auth.google');

// Authenticated
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Verification flow
    Route::get('/verification', [VerificationController::class, 'index'])->name('verification.index');
    Route::post('/verification/upload', [VerificationController::class, 'uploadDocuments'])->name('verification.upload');
    Route::post('/verification/buy-package', [VerificationController::class, 'buyPackage'])->name('verification.buy_package');

    // Profile & Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Verified Users Only
    Route::middleware('verified')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/step', [OrderController::class, 'updateStep'])->name('orders.step');
        Route::post('/orders/{order}/duplicate', [OrderController::class, 'duplicate'])->name('orders.duplicate');

        Route::get('/orders/{order}/mou', [MouController::class, 'show'])->name('mou.show');
        Route::get('/orders/{order}/mou/download', [MouController::class, 'download'])->name('mou.download');
        Route::post('/orders/{order}/mou/upload', [MouController::class, 'uploadSigned'])->name('mou.upload');

        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');

        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/invoices/{invoice}/pay', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('/invoices/{invoice}/pay', [PaymentController::class, 'store'])->name('payments.store');

        Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
        Route::get('/tracking/{order}', [TrackingController::class, 'show'])->name('tracking.show');

        Route::get('/layanan/legalitas', [LegalitasController::class, 'index'])->name('layanan.legalitas');
    });

    // API for order wizard
    Route::middleware('verified')->prefix('api')->name('api.')->group(function () {
        Route::get('/products', [OrderController::class, 'apiProducts'])->name('products');
        Route::get('/products/{product}', [OrderController::class, 'apiProduct'])->name('product');
        Route::get('/materials', [OrderController::class, 'apiMaterials'])->name('materials');
        Route::get('/packaging', [OrderController::class, 'apiPackaging'])->name('packaging');
    });
});

// Admin Only
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::put('/orders/{order}/production', [Admin\OrderController::class, 'updateProduction'])->name('orders.production');
    Route::post('/orders/{order}/invoice', [Admin\OrderController::class, 'createInvoice'])->name('orders.invoice');

    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}/toggle', [Admin\UserController::class, 'toggleStatus'])->name('users.toggle');

    Route::get('/verifikasi', [Admin\VerificationController::class, 'index'])->name('verifikasi.index');
    Route::get('/verifikasi/{user}', [Admin\VerificationController::class, 'show'])->name('verifikasi.show');
    Route::put('/verifikasi/{user}/approve', [Admin\VerificationController::class, 'approve'])->name('verifikasi.approve');
    Route::put('/verifikasi/{user}/reject', [Admin\VerificationController::class, 'reject'])->name('verifikasi.reject');

    Route::get('/mou', [Admin\MouController::class, 'index'])->name('mou.index');
    Route::get('/mou/{mou}', [Admin\MouController::class, 'show'])->name('mou.show');
    Route::put('/mou/{mou}/approve', [Admin\MouController::class, 'approve'])->name('mou.approve');
    Route::put('/mou/{mou}/reject', [Admin\MouController::class, 'reject'])->name('mou.reject');

    Route::resource('/produk', Admin\ProductController::class)->except(['show']);
    Route::get('/produk/api-list', [Admin\ProductController::class, 'apiList'])->name('produk.api');
    Route::resource('/material', Admin\MaterialController::class)->except(['show', 'create', 'edit']);
    Route::resource('/kemasan', Admin\PackagingController::class)->except(['show', 'create', 'edit']);

    Route::get('/invoices', [Admin\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [Admin\InvoiceController::class, 'show'])->name('invoices.show');
    Route::put('/invoices/{invoice}/status', [Admin\InvoiceController::class, 'updateStatus'])->name('invoices.status');

    Route::get('/payments', [Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::put('/payments/{payment}/verify', [Admin\PaymentController::class, 'verify'])->name('payments.verify');

    Route::get('/settings', [Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/password', [Admin\SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/admin', [Admin\SettingsController::class, 'addAdmin'])->name('settings.add_admin');
});

// Super Admin Only
Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->name('super_admin.')->group(function () {
    Route::get('/dashboard', [SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admins', [SuperAdmin\AdminController::class, 'index'])->name('admins.index');
    Route::post('/admins', [SuperAdmin\AdminController::class, 'store'])->name('admins.store');
    Route::put('/admins/{user}', [SuperAdmin\AdminController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{user}', [SuperAdmin\AdminController::class, 'destroy'])->name('admins.destroy');
    Route::get('/reports', [SuperAdmin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/audit-log', [SuperAdmin\AuditController::class, 'index'])->name('audit.index');
});
