<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StockPurchaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('item-categories', ItemCategoryController::class);
    Route::resource('items', ItemController::class);
    Route::resource('stock-purchases', StockPurchaseController::class);
    Route::get('stock-purchases', [StockPurchaseController::class, 'index']);
    Route::get('stock-purchases/{stockPurchase}', [StockPurchaseController::class, 'show']);
    
    Route::middleware(['role:admin'])->group(function () {
        
    });

    Route::middleware(['permission:view-stock-purchases'])->group(function () {
        
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

Route::get('clear-cache', function() {
    Artisan::call('optimize');
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
});

Auth::routes();

