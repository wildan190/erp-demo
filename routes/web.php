<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Protected dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Profile Management
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Customers CRUD
    Route::resource('customers', CustomerController::class);

    // API endpoints for customers (requires auth)
    Route::prefix('api')->group(function () {
        Route::get('/customers', [CustomerController::class, 'apiIndex']);
        Route::get('/customers/{customer}', [CustomerController::class, 'apiShow']);
    });

    // Products CRUD
    Route::resource('products', ProductController::class);

    // API endpoints for products
    Route::prefix('api')->group(function () {
        Route::get('/products', [ProductController::class, 'apiIndex']);
        Route::get('/products/{product}', [ProductController::class, 'apiShow']);
    });

    // Orders & Invoices
    Route::resource('orders', OrderController::class);
    Route::resource('invoices', InvoiceController::class)->only(['index','show']);
    Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    
    // Purchases & Suppliers
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);
    Route::resource('purchases', \App\Http\Controllers\PurchaseController::class)->only(['index','create','store','show','destroy']);

    Route::post('orders/{order}/invoice', [InvoiceController::class, 'storeForOrder'])->name('orders.invoice');
    Route::post('invoices/{invoice}/pay', [InvoiceController::class, 'markPaid'])->name('invoices.pay');

    // CRM Modules
    Route::resource('quotations', App\Http\Controllers\QuotationController::class);
    Route::resource('delivery-orders', App\Http\Controllers\DeliveryOrderController::class);
    Route::resource('leads', App\Http\Controllers\LeadController::class);
    Route::resource('opportunities', App\Http\Controllers\OpportunityController::class);
    Route::resource('follow-ups', App\Http\Controllers\FollowUpController::class);

    // Financial & Accounting Modules
    Route::prefix('finance')->name('finance.')->group(function () {
        // General Ledger
        Route::get('gl', [App\Http\Controllers\GeneralLedgerController::class, 'index'])->name('gl.index');

        // GL Accounts
        Route::get('gl/accounts', [App\Http\Controllers\GLAccountController::class, 'index'])->name('gl.accounts.index');
        Route::get('gl/accounts/create', [App\Http\Controllers\GLAccountController::class, 'create'])->name('gl.accounts.create');
        Route::post('gl/accounts', [App\Http\Controllers\GLAccountController::class, 'store'])->name('gl.accounts.store');
        Route::get('gl/accounts/{account}', [App\Http\Controllers\GLAccountController::class, 'show'])->name('gl.accounts.show');
        Route::get('gl/accounts/{account}/edit', [App\Http\Controllers\GLAccountController::class, 'edit'])->name('gl.accounts.edit');
        Route::put('gl/accounts/{account}', [App\Http\Controllers\GLAccountController::class, 'update'])->name('gl.accounts.update');
        Route::delete('gl/accounts/{account}', [App\Http\Controllers\GLAccountController::class, 'destroy'])->name('gl.accounts.destroy');

        // GL Transactions
        Route::get('gl/transactions', [App\Http\Controllers\GLTransactionController::class, 'index'])->name('gl.transactions.index');
        Route::get('gl/transactions/create', [App\Http\Controllers\GLTransactionController::class, 'create'])->name('gl.transactions.create');
        Route::post('gl/transactions', [App\Http\Controllers\GLTransactionController::class, 'store'])->name('gl.transactions.store');
        Route::get('gl/transactions/{transaction}', [App\Http\Controllers\GLTransactionController::class, 'show'])->name('gl.transactions.show');
        Route::get('gl/transactions/{transaction}/edit', [App\Http\Controllers\GLTransactionController::class, 'edit'])->name('gl.transactions.edit');
        Route::put('gl/transactions/{transaction}', [App\Http\Controllers\GLTransactionController::class, 'update'])->name('gl.transactions.update');
        Route::delete('gl/transactions/{transaction}', [App\Http\Controllers\GLTransactionController::class, 'destroy'])->name('gl.transactions.destroy');

        // Accounts Payable
        Route::get('ap', [App\Http\Controllers\AccountsPayableController::class, 'index'])->name('ap.index');

        // AP Bills
        Route::get('ap/bills', [App\Http\Controllers\APBillController::class, 'index'])->name('ap.bills.index');
        Route::get('ap/bills/create', [App\Http\Controllers\APBillController::class, 'create'])->name('ap.bills.create');
        Route::post('ap/bills', [App\Http\Controllers\APBillController::class, 'store'])->name('ap.bills.store');
        Route::get('ap/bills/{bill}', [App\Http\Controllers\APBillController::class, 'show'])->name('ap.bills.show');
        Route::get('ap/bills/{bill}/edit', [App\Http\Controllers\APBillController::class, 'edit'])->name('ap.bills.edit');
        Route::put('ap/bills/{bill}', [App\Http\Controllers\APBillController::class, 'update'])->name('ap.bills.update');
        Route::delete('ap/bills/{bill}', [App\Http\Controllers\APBillController::class, 'destroy'])->name('ap.bills.destroy');
        Route::post('ap/bills/{bill}/pay', [App\Http\Controllers\APBillController::class, 'pay'])->name('ap.bills.pay');

        // Accounts Receivable
        Route::get('ar', [App\Http\Controllers\AccountsReceivableController::class, 'index'])->name('ar.index');

        // AR Payments
        Route::get('ar/payments', [App\Http\Controllers\ARPaymentReceivedController::class, 'index'])->name('ar.payments.index');
        Route::get('ar/payments/create', [App\Http\Controllers\ARPaymentReceivedController::class, 'create'])->name('ar.payments.create');
        Route::post('ar/payments', [App\Http\Controllers\ARPaymentReceivedController::class, 'store'])->name('ar.payments.store');
        Route::get('ar/payments/{payment}', [App\Http\Controllers\ARPaymentReceivedController::class, 'show'])->name('ar.payments.show');
        Route::get('ar/payments/{payment}/edit', [App\Http\Controllers\ARPaymentReceivedController::class, 'edit'])->name('ar.payments.edit');
        Route::put('ar/payments/{payment}', [App\Http\Controllers\ARPaymentReceivedController::class, 'update'])->name('ar.payments.update');
        Route::delete('ar/payments/{payment}', [App\Http\Controllers\ARPaymentReceivedController::class, 'destroy'])->name('ar.payments.destroy');

        // Fixed Assets
        Route::get('fixed-assets', [App\Http\Controllers\FixedAssetController::class, 'index'])->name('fixed-assets.index');
        Route::get('fixed-assets/create', [App\Http\Controllers\FixedAssetController::class, 'create'])->name('fixed-assets.create');
        Route::post('fixed-assets', [App\Http\Controllers\FixedAssetController::class, 'store'])->name('fixed-assets.store');
        Route::get('fixed-assets/{fixedAsset}', [App\Http\Controllers\FixedAssetController::class, 'show'])->name('fixed-assets.show');
        Route::get('fixed-assets/{fixedAsset}/edit', [App\Http\Controllers\FixedAssetController::class, 'edit'])->name('fixed-assets.edit');
        Route::put('fixed-assets/{fixedAsset}', [App\Http\Controllers\FixedAssetController::class, 'update'])->name('fixed-assets.update');
        Route::delete('fixed-assets/{fixedAsset}', [App\Http\Controllers\FixedAssetController::class, 'destroy'])->name('fixed-assets.destroy');

        // Bank Reconciliation
        Route::get('bank-reconciliation', [App\Http\Controllers\BankReconciliationController::class, 'index'])->name('bank.reconciliation.index');

        // Bank Accounts
        Route::get('bank-accounts', [App\Http\Controllers\BankAccountController::class, 'index'])->name('bank-accounts.index');
        Route::get('bank-accounts/create', [App\Http\Controllers\BankAccountController::class, 'create'])->name('bank-accounts.create');
        Route::post('bank-accounts', [App\Http\Controllers\BankAccountController::class, 'store'])->name('bank-accounts.store');
        Route::get('bank-accounts/{bankAccount}', [App\Http\Controllers\BankAccountController::class, 'show'])->name('bank-accounts.show');
        Route::get('bank-accounts/{bankAccount}/edit', [App\Http\Controllers\BankAccountController::class, 'edit'])->name('bank-accounts.edit');
        Route::put('bank-accounts/{bankAccount}', [App\Http\Controllers\BankAccountController::class, 'update'])->name('bank-accounts.update');
        Route::delete('bank-accounts/{bankAccount}', [App\Http\Controllers\BankAccountController::class, 'destroy'])->name('bank-accounts.destroy');

        // Bank Transactions
        Route::get('bank-transactions', [App\Http\Controllers\BankTransactionController::class, 'index'])->name('bank-transactions.index');
        Route::get('bank-transactions/{bankTransaction}', [App\Http\Controllers\BankTransactionController::class, 'show'])->name('bank-transactions.show');
        Route::delete('bank-transactions/{bankTransaction}', [App\Http\Controllers\BankTransactionController::class, 'destroy'])->name('bank-transactions.destroy');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('sales', [\App\Http\Controllers\Reports\SalesController::class, 'index'])->name('sales');
        Route::get('inventory', [\App\Http\Controllers\Reports\InventoryController::class, 'index'])->name('inventory');
        Route::get('general-ledger-account-statement', [\App\Http\Controllers\Reports\GeneralLedgerController::class, 'index'])->name('general-ledger-account-statement');
    });

    // API endpoints
    Route::prefix('api')->group(function () {
        Route::get('/orders', [OrderController::class, 'apiIndex']);
        Route::get('/orders/{order}', [OrderController::class, 'apiShow']);
        Route::get('/invoices', [InvoiceController::class, 'apiIndex']);
        Route::get('/invoices/{invoice}', [InvoiceController::class, 'apiShow']);
    });

    // Admin routes (only for admin role)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Admin\UsersController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/role', [\App\Http\Controllers\Admin\UsersController::class, 'update'])->name('users.update');
    });
});
