<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USERS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD (SEMUA ROLE)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROFILE (BREEZE)
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | OWNER ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:owner')->group(function () {
        // Reports
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
            Route::get('/export', [UserController::class, 'export'])->name('export');

            // Bulk Actions
            Route::post('/bulk/activate', [UserController::class, 'bulkActivate'])->name('bulk-activate');
            Route::post('/bulk/deactivate', [UserController::class, 'bulkDeactivate'])->name('bulk-deactivate');
            Route::post('/bulk/delete', [UserController::class, 'bulkDelete'])->name('bulk-delete');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | OWNER & KEPALA GUDANG
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:owner,gudang')->group(function () {
        Route::resource('products', ProductController::class)
            ->except('show');
    });

    /*
    |--------------------------------------------------------------------------
    | KASIR
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:kasir,owner')->group(function () {
        // Produk (read only)
        Route::get('/products', [ProductController::class, 'index'])
            ->name('products.index');

        Route::get('/products/{product}', [ProductController::class, 'show'])
            ->name('products.show');

        // Transaksi
        Route::get('/transactions', [TransactionController::class, 'index'])
            ->name('transactions.index');

        Route::post('/transactions', [TransactionController::class, 'store'])
            ->name('transactions.store');

        Route::get('/transactions/history', [TransactionController::class, 'history'])
            ->name('transactions.history');
    });
});
