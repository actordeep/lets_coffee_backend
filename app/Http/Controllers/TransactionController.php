<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

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
        'amount' => 'required|integer', // Adjusted to allow decimal amounts
        'status' => 'required|string',
        'transaction_type' => 'required|string', // Adjusted with valid values
    ]);
    // return 0;

    $now = Carbon::now('Asia/Kolkata');

    $status = $request->status;

    if (!in_array($status, ['pending', 'success', 'failed'])) {
        return response()->json(['error' => 'Invalid status for the transaction.'], 400);
    }

    $message = '';
    switch ($status) {
        case 'pending':
            $message = 'Transaction is pending. Waiting for processing.';
            break;
        case 'success':
            $message = 'Transaction completed successfully.';
            break;
        case 'failed':
            $message = 'Transaction failed. Please check the details and try again.';
            break;
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
