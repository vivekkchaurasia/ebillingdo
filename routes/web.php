<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockPurchaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mews\Captcha\Captcha;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'home' : 'login');
});

Route::get('captcha', [Captcha::class, 'create']);

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('item-categories', ItemCategoryController::class);
    Route::resource('items', ItemController::class);
    Route::resource('stock-purchases', StockPurchaseController::class);
    
    Route::resource('invoices', InvoiceController::class);
    Route::get('/ListInvoice', [InvoiceController::class, 'ListInvoice'])->name('invoices.ListInvoice');
    Route::get('/invoices/{id}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.downloadPdf');

    Route::get('/stock-report', [ItemController::class, 'stockReport'])->name('stock.report');

    Route::get('/items/by-category/{id}', [ItemController::class, 'getItemsByCategory']);
    
    Route::middleware(['role:admin'])->group(function () {
        
    });

    Route::middleware(['permission:view-stock-purchases'])->group(function () {
        
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/stock-report/filter', [ItemController::class, 'filterStockReport'])->name('stock.report.filter');
});

Route::get('clear-cache', function() {
    Artisan::call('cache:clear');
    echo "Cache Cleared ..............<br>";
    Artisan::call('route:clear');
    echo "Cache Cleared ..............<br>";
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

