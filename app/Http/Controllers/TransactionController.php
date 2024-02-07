<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();

        return response()->json(['data' => $transactions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'amount' => 'required|integer|min:1',
            'status' => 'required|string',
            'transaction_type' => 'required|string',
        ]);
        // return 0;

        $now = Carbon::now('Asia/Kolkata');

        $status = $request->status;

        if ($status === 'pending') {
            $message = 'Transaction is pending. Waiting for processing.';
        } elseif ($status === 'success') {
            $message = 'Transaction completed successfully.';
        } elseif ($status === 'failed') {
            $message = 'Transaction failed. Please check the details and try again.';
        } else {
            $message = 'Invalid status for the transaction.';
        }

        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'transaction_id' => uniqid(),
            'amount' => $request->amount,
            'status' => $status,
            'transaction_type' => $request->transaction_type,
            'date_time' => $now,
        ]);

        $formattedDateTime = $now->format('Y-m-d H:i:s');

        return response()->json(['message' => $message, 'data' => ['transaction' => $transaction, 'formattedDateTime' => $formattedDateTime]]);
    }
}
