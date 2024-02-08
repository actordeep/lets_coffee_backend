<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class GetTransactionController extends Controller
{
    //
    public function getUserTransactions(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        // Get the user_id from the request
        $user_id = $request->input('user_id');

        // Get all transactions of the specified user
        $userTransactions = Transaction::where('user_id', $user_id)->get();

        // Get the last transaction record of the specified user
        $lastTransaction = $userTransactions->isEmpty() ? null : $userTransactions->last();

        return response()->json([
            'user_transactions' => $userTransactions,
            'last_transaction' => $lastTransaction,
        ]);
    }
}
