<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\GoogleAuthController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\Customer\DashboardController;
use App\Http\Controllers\Api\Customer\InvoiceController;
use App\Http\Controllers\Api\Customer\LegalityController;
use App\Http\Controllers\Api\Customer\MouController;
use App\Http\Controllers\Api\Customer\OrderController;
use App\Http\Controllers\Api\Customer\PaymentController;
use App\Http\Controllers\Api\Customer\ProfileController;
use App\Http\Controllers\Api\Customer\TrackingController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Api\Admin\FinanceController;
use App\Http\Controllers\Api\Admin\MouVerificationController;
use App\Http\Controllers\Api\Admin\OrderManagementController;
use App\Http\Controllers\Api\Admin\SettingsController;
use App\Http\Controllers\Api\Admin\UserVerificationController;
use App\Http\Controllers\Api\Admin\MasterData\CategoryController;
use App\Http\Controllers\Api\Admin\MasterData\MaterialController;
use App\Http\Controllers\Api\Admin\MasterData\PackagingController;
use App\Http\Controllers\Api\Admin\MasterData\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('google/redirect', [GoogleAuthController::class, 'redirect']);
    Route::get('google/callback', [GoogleAuthController::class, 'callback']);
});

// Public catalog (no auth required)
Route::prefix('catalog')->group(function () {
    Route::get('categories', [CatalogController::class, 'categories']);
    Route::get('products', [CatalogController::class, 'products']);
    Route::get('products/{product}', [CatalogController::class, 'product']);
    Route::get('materials', [CatalogController::class, 'materials']);
    Route::get('packaging', [CatalogController::class, 'packaging']);
    Route::post('calculate-price', [CatalogController::class, 'calculatePrice']);
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::post('auth/change-password', [AuthController::class, 'changePassword']);

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER ROUTES (verified users only for orders)
    |--------------------------------------------------------------------------
    */
    Route::prefix('customer')->group(function () {
        // Dashboard (unverified can see this)
        Route::get('dashboard', [DashboardController::class, 'index']);

        // Profile
        Route::get('profile', [ProfileController::class, 'show']);
        Route::put('profile', [ProfileController::class, 'update']);
        Route::get('notifications', [ProfileController::class, 'notifications']);
        Route::post('notifications/{id}/read', [ProfileController::class, 'markNotificationRead']);
        Route::post('notifications/read-all', [ProfileController::class, 'markAllNotificationsRead']);

        // Legality
        Route::get('legality/status', [LegalityController::class, 'status']);
        Route::post('legality/upload-document', [LegalityController::class, 'uploadDocument']);
        Route::post('legality/buy-package', [LegalityController::class, 'buyPackage']);

        // Orders (all steps)
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/{order}', [OrderController::class, 'show']);
        Route::post('orders/{order}/duplicate', [OrderController::class, 'duplicate']);
        Route::post('orders/{order}/upload-design', [OrderController::class, 'uploadDesign']);

        // Multi-step order creation (verified required for step 1+)
        Route::middleware('verified.customer')->group(function () {
            Route::post('orders', [OrderController::class, 'storeStep1']);
            Route::put('orders/{order}/step2', [OrderController::class, 'updateStep2']);
            Route::put('orders/{order}/step3', [OrderController::class, 'updateStep3']);
            Route::put('orders/{order}/step4', [OrderController::class, 'updateStep4']);
            Route::put('orders/{order}/step5', [OrderController::class, 'updateStep5']);
            Route::put('orders/{order}/step5-sample', [OrderController::class, 'updateStep5Sample']);
            Route::post('orders/{order}/submit', [OrderController::class, 'submit']);
        });

        // MOU
        Route::get('orders/{order}/mou', [MouController::class, 'show']);
        Route::get('orders/{order}/mou/download', [MouController::class, 'download']);
        Route::post('orders/{order}/mou/upload-signed', [MouController::class, 'uploadSigned']);

        // Tracking
        Route::get('orders/{order}/tracking', [TrackingController::class, 'show']);

        // Invoices
        Route::get('invoices', [InvoiceController::class, 'index']);
        Route::get('invoices/{invoice}', [InvoiceController::class, 'show']);
        Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download']);

        // Payments
        Route::get('payments', [PaymentController::class, 'index']);
        Route::post('invoices/{invoice}/upload-payment', [PaymentController::class, 'uploadProof']);
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->middleware('ensure.admin')->group(function () {
        // Dashboard
        Route::get('dashboard', [AdminDashboard::class, 'index']);

        // User Verification
        Route::prefix('verifications')->group(function () {
            Route::get('pending', [UserVerificationController::class, 'pending']);
            Route::get('history', [UserVerificationController::class, 'history']);
            Route::get('users/{user}', [UserVerificationController::class, 'show']);
            Route::post('users/{user}/approve', [UserVerificationController::class, 'approve']);
            Route::post('users/{user}/reject', [UserVerificationController::class, 'reject']);
        });

        // User Management
        Route::prefix('users')->group(function () {
            Route::get('/', [UserVerificationController::class, 'allUsers']);
            Route::patch('{user}/toggle-active', [UserVerificationController::class, 'toggleActive']);
        });

        // MOU Verification
        Route::prefix('mous')->group(function () {
            Route::get('pending', [MouVerificationController::class, 'pending']);
            Route::get('history', [MouVerificationController::class, 'history']);
            Route::get('{mou}', [MouVerificationController::class, 'show']);
            Route::post('{mou}/approve', [MouVerificationController::class, 'approve']);
            Route::post('{mou}/reject', [MouVerificationController::class, 'reject']);
        });

        // Order Management
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderManagementController::class, 'index']);
            Route::get('{order}', [OrderManagementController::class, 'show']);
            Route::patch('{order}/status', [OrderManagementController::class, 'updateStatus']);
            Route::post('{order}/shipping', [OrderManagementController::class, 'updateShipping']);
        });

        // Payment Confirmation
        Route::prefix('payments')->group(function () {
            Route::get('pending', [OrderManagementController::class, 'pendingPayments']);
            Route::post('{payment}/confirm', [OrderManagementController::class, 'confirmPayment']);
        });

        // Finance
        Route::prefix('finance')->group(function () {
            Route::get('invoices', [FinanceController::class, 'invoices']);
            Route::get('payments', [FinanceController::class, 'payments']);
            Route::get('summary', [FinanceController::class, 'summary']);
        });

        // Master Data - Categories
        Route::prefix('master/categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('tree', [CategoryController::class, 'tree']);
            Route::post('/', [CategoryController::class, 'store']);
            Route::put('{category}', [CategoryController::class, 'update']);
            Route::delete('{category}', [CategoryController::class, 'destroy']);
        });

        // Master Data - Products
        Route::prefix('master/products')->group(function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::post('/', [ProductController::class, 'store']);
            Route::put('{product}', [ProductController::class, 'update']);
            Route::delete('{product}', [ProductController::class, 'destroy']);
        });

        // Master Data - Materials
        Route::prefix('master/materials')->group(function () {
            Route::get('/', [MaterialController::class, 'index']);
            Route::post('/', [MaterialController::class, 'store']);
            Route::put('{material}', [MaterialController::class, 'update']);
            Route::delete('{material}', [MaterialController::class, 'destroy']);
        });

        // Master Data - Packaging
        Route::prefix('master/packaging')->group(function () {
            Route::get('types', [PackagingController::class, 'indexTypes']);
            Route::post('types', [PackagingController::class, 'storeType']);
            Route::put('types/{packagingType}', [PackagingController::class, 'updateType']);
            Route::post('types/{packagingType}/options', [PackagingController::class, 'storeOption']);
            Route::put('options/{packagingOption}', [PackagingController::class, 'updateOption']);
            Route::delete('options/{packagingOption}', [PackagingController::class, 'destroyOption']);
        });

        // Settings
        Route::prefix('settings')->group(function () {
            Route::get('/', [SettingsController::class, 'index']);
            Route::put('/', [SettingsController::class, 'update']);
            Route::get('admins', [SettingsController::class, 'adminUsers']);
            Route::post('admins', [SettingsController::class, 'createAdmin']);
            Route::get('audit-logs', [SettingsController::class, 'auditLogs']);
        });
    });
});
