<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StockPurchaseController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json(['token' => $token]);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('api-item-categories', ItemCategoryController::class);
    Route::apiResource('api-items', ItemController::class);
    Route::apiResource('api-stock-purchases', StockPurchaseController::class);
    Route::apiResource('api-invoices', StockPurchaseController::class);

    Route::get('/items/by-category/{id}', [ItemController::class, 'getItemsByCategory'])->name('api.items.by-category');

    Route::middleware(['role:admin'])->group(function () {
        
    });

    Route::middleware(['permission:view-stock-purchases'])->group(function () {
        
    });
});
