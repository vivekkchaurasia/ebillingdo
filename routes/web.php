<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockPurchaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionsController;
use App\Http\Controllers\UserRolesController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mews\Captcha\Captcha;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'home' : 'login');
});

Route::get('captcha', [Captcha::class, 'create']);

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('item-categories', ItemCategoryController::class)->middleware('permission:view-item-categories');
    Route::resource('items', ItemController::class)->middleware('permission:view-items');
    Route::resource('stock-purchases', StockPurchaseController::class)->middleware('permission:view-stock-purchases');
    Route::resource('users', UserController::class)->middleware('permission:view-users');
    Route::resource('user-roles', UserRolesController::class)->middleware('permission:view-roles');
    Route::resource('user-permissions', UserPermissionsController::class)->middleware('permission:view-permissions');
    Route::resource('invoices', InvoiceController::class)->middleware('permission:view-invoices');
    Route::get('/ListInvoice', [InvoiceController::class, 'ListInvoice'])->name('invoices.ListInvoice')->middleware('permission:view-invoices');
    Route::get('/invoices/{id}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.downloadPdf')->middleware('permission:view-invoices');
    Route::get('/stock-report', [ItemController::class, 'stockReport'])->name('stock.report')->middleware('permission:view-stock-report');
    Route::get('/items/by-category/{id}', [ItemController::class, 'getItemsByCategory'])->middleware('permission:view-items');
});

Route::get('clear-cache', function() {
    Artisan::call('cache:clear');
    echo "Cache Cleared ..............<br>";
    Artisan::call('route:clear');
    echo "Route Cleared ..............<br>";
    Artisan::call('config:clear');
    echo "Config Cleared ..............<br>";
    Artisan::call('view:clear');
    echo "View Cleared ..............<br>";
    Artisan::call('optimize');
    echo "Optimized ..............<br>";
    Artisan::call('optimize:clear');
    echo "Optimize Cleared ..............<br>";
});

Auth::routes();
