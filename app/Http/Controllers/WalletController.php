<?php

namespace App\Http\Controllers;
// require "C:\wamp64\www\Wallet_API\app\Http\Requests\StoreWalletRequest copy.php";

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\StoreWalletRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\WalletResource;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class WalletController extends Controller

{

  public function index(Request $request): JsonResponse
  {
    $wallets = Wallet::all();
    return response()->json([
      'status' => 'success',
      'message' => 'showing wallets successful',
      'data' => $wallets
    ]);
  }

  // POST /api/wallets
  public function store(StoreWalletRequest $request): JsonResponse
  {
    $validated = $request->validated();
    //   [
    // 'name' => 'required|string|max:255',
    // 'desc'=> 'required|string'
    // ]);


    $wallet = Wallet::create($validated);

    return response()->json([
      'status' => 'success',
      'message' => 'Wallet créée avec succès',
      'data' => $wallet
    ], 201);
  }

  public function deposit(StoreTransactionRequest $request, Wallet $wallet){
    
    $validated=$request->validated();
    $validated['type']='deposit';
    $validated['wallet_id'] = $wallet->id;
    $wallet->balance+=$validated['amount'];
    $wallet->save();
    $deposit=Transaction::create($validated);
    return response()->json(['status'=>'success','message'=>'deposit executed successfully','data'=> ['transaction'=>new TransactionResource($deposit) ,'wallet'=>new WalletResource($wallet) ]],201);
  }
  public function withdraw(StoreTransactionRequest $request, Wallet $wallet){
    
    $validated=$request->validated();
    $validated['type']='withdrawl';
    $validated['wallet_id'] = $wallet->id;
    $wallet->balance-=$validated['amount'];
    $wallet->save();
    $draw=Transaction::create($validated);
    return response()->json(['status'=>'success','message'=>'withdrawl executed successfully','data'=> ['transaction'=>new TransactionResource($draw) ,'wallet'=>new WalletResource($wallet) ]],201);
  }
  public function show(Wallet $wallet): JsonResponse
  {
    $wallet->load('transactions');
    return response()->json([
      'status' => 'success',
      'message' => 'Wallet shown successfully',
      'data' => $wallet
    ]);
  }

  // PUT /api/wallets/{id}
  public function update(Request $request, Wallet $wallet): JsonResponse
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'currency' => 'required|string|size:3',
      'balance' => 'required|decimal:0,2',
      'user_id' => 'sometimes'
    ]);
    $wallet->update($validated);

    return response()->json([
      'status' => 'success',
      'message' => 'Wallet updated successfully',
      'data' => $wallet
    ]);
  }
  public function destroy(Wallet $wallet): JsonResponse
  {
    $wallet->delete();
    return response()->json([
      'status' => 'success',
      'message' => 'Wallet deleted successfuly'
    ]);
  }


  public function transactions(Wallet $wallet): JsonResponse
  {
    return response()->json([
      'status' => 'success',
      'message' => 'transactions shown sucessfully',
      'data' => $wallet->transactions
    ]);
  }
}
