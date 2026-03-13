<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Requests\storeWalletRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (StoreWalletRequest $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('wallets',WalletController::class);
Route::apiResource('transactions', TransactionController::class);
Route::get('wallets/{wallet}/transactions',[WalletController::class,'transactions']);
Route::post('wallets/{wallet}/deposit',[WalletController::class,'deposit']);
Route::post('wallets/{wallet}/withdraw',[WalletController::class,'withdraw']);

