<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\MerchantController;
use App\Models\Menus;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/merchants', [MerchantController::class, 'index']);
Route::post('/merchants', [MerchantController::class, 'addMerchant']);
Route::put('/merchants/{id}', [MerchantController::class, 'update']);
Route::post('/menus', [MenuController::class, 'addMenu']);
Route::get('/menus/{merchant_id}', [MenuController::class, 'menu']);
Route::get('/category', [MenuController::class, 'category']);
Route::post('/category', [MenuController::class, 'addCategory']);
Route::get('/ongkir', [MerchantController::class, 'ongkir']);
Route::post('merchant/upload', [MerchantController::class, 'upload']);
