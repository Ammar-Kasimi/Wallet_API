<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeTransactionRequest;
use App\Http\Requests\transferTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{


    public function index()
    {
        $transaction = Transaction::with('wallet')->get();
        return response()->json(['status' => 'success', 'data' => $transaction]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeTransactionRequest $request)
    {
        // $validated = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'author' => 'required|string|max:255',
        //     'isbn' => 'required|string|unique:transactions,isbn',
        //     'published_year' => 'required|integer|min:1000|max:' . date('Y'),
        //     'wallet_id' => 'required|exists:categories,id'
        // ]);
        $transaction = Transaction::create($request->validated());
        $transaction->load('wallet');
        return response()->json(['status' => 'sucess', 'message' => 'transaction created successufly', 'data' => $transaction], 201);
    }
    public function transfer(transferTransactionRequest $request, Wallet $wallet)
    {

        $validated = $request->validated();
        $validated2 = $validated;
        $validated2['receiver_wallet_id'] = -$validated['receiver_wallet_id'];
        $validated['type'] = 'transfer';
        // $validated['wallet_id'] = $wallet->id;
        $wallet->balance -= $validated['amount'];
        $wallet->save();
        Transaction::create($validated2);
        $deposit = Transaction::create($validated);
        return response()->json(['status' => 'success', 'message' => 'deposit executed successfully', 'data' => ['transaction' => new TransactionResource($deposit), 'wallet' => new WalletResource($wallet)]], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('wallet');
        return response()->json(['status' => 'success', 'message' => 'transaction shown successfuly', 'data' => $transaction]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'amount' => 'required|decimal',
            'desc' => 'sometimes|string',
            'wallet_id' => 'sometimes'
        ]);

        $transaction->update($validated);
        $transaction->load('wallet');

        return response()->json([
            'status' => 'success',
            'message' => 'transaction mis à jour',
            'data' => $transaction
        ]);
    }
 
     // DELETE /api/transactions/


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return response()->json(['status' => 'sucess', 'message' => 'transaction deleted successfuly']);
    }
}
