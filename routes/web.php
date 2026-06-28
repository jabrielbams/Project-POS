<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SalesDocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect('/login');
});

Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/admin/stores', \App\Livewire\Admin\StoreIndex::class)->name('admin.stores.index');
    Route::get('/admin/stores/create', [\App\Http\Controllers\Admin\StoreController::class, 'create'])->name('admin.stores.create');
    Route::post('/admin/stores', [\App\Http\Controllers\Admin\StoreController::class, 'store'])->name('admin.stores.store');
    Route::get('/admin/stores/{store}/edit', [\App\Http\Controllers\Admin\StoreController::class, 'edit'])->name('admin.stores.edit');
    Route::put('/admin/stores/{store}', [\App\Http\Controllers\Admin\StoreController::class, 'update'])->name('admin.stores.update');
    Route::delete('/admin/stores/{store}', [\App\Http\Controllers\Admin\StoreController::class, 'destroy'])->name('admin.stores.destroy');

    Route::get('/admin/products', \App\Livewire\Admin\ProductIndex::class)->name('admin.products.index');
    Route::get('/admin/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/admin/products/{product}/detail', \App\Livewire\Admin\Products\ProductDetail::class)->name('admin.products.show');

    Route::get('/admin/pos', [\App\Http\Controllers\Admin\PosController::class, 'index'])->name('admin.pos.terminal');
    Route::post('/admin/pos/checkout', [\App\Http\Controllers\Admin\PosController::class, 'checkout'])->name('admin.pos.checkout');
    Route::get('/admin/sales-history', \App\Livewire\Admin\SalesHistory::class)->name('admin.sales-history.index');
    Route::post('/admin/sales-history/report', [SalesDocumentController::class, 'salesHistoryReport'])->name('admin.sales-history.report');
    Route::get('/admin/activity-log', \App\Livewire\Admin\ActivityLog::class)->name('admin.activity-log.index');
    Route::get('/admin/sales/{id}', \App\Livewire\Admin\Sales\SalesDetail::class)->name('admin.sales.show');
    Route::get('/admin/sales/{sale}/invoice', [SalesDocumentController::class, 'invoice'])->name('admin.sales.invoice');
    Route::post('/admin/sales/{id}/pay-installment', [\App\Http\Controllers\Admin\PosController::class, 'payInstallment'])->name('admin.sales.pay-installment');
});

// Catch-all: redirect unregistered paths to dashboard or login
Route::fallback(function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});
