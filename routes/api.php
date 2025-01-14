<?php

use App\Http\Controllers\MenuController;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Menus;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/merchants', [MerchantController::class, 'index']);
Route::get('/menus/{id_menu}', [MenuController::class, 'menu']);
Route::get('/category/{id_merchant}', [MenuController::class, 'category']);
Route::get('/ongkir', [MerchantController::class, 'ongkir']);
Route::post('/checkout', [TransactionController::class, 'checkout']);
Route::get('/order/{id_transaction}', [TransactionController::class, 'order']);
Route::get('/orders', [TransactionController::class, 'orderAll']);
Route::get('/order/details/{id_transaction}', [TransactionController::class, 'orderDetail']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware([ApiKeyMiddleware::class])->group(function () {
    Route::post('/merchants', [MerchantController::class, 'addMerchant']);
    Route::put('/merchants/update/{id_merchant}', [MerchantController::class, 'update']);
    Route::post('merchant/upload', [MerchantController::class, 'uploadMerchant']);
    Route::post('/menus', [MenuController::class, 'addMenu']);
    Route::post('/menu/upload', [MenuController::class, 'uploadMenu']);
    Route::put('/menu/update/{id_menu}', [MenuController::class, 'updateMenu']);
    Route::put('/menu/delete', [MenuController::class, 'deleteMenu']);
    Route::post('/category', [MenuController::class, 'addCategory']);
});

