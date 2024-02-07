<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\orderstatusController;
use App\Models\Order;

class orderstatusController extends Controller
{
    public function getStatusOrder(Request $request, $orderId)
{
    $request->validate([
        'status' => 'required|in:preparing,ready_for_pickup,completed',
    ]);

    $order = Order::find($orderId);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Ensure the new status is in the correct order
    if ($order->status_order >= $this->getStatusOrder($request->status)) {
        return response()->json(['message' => 'Invalid status progression'], 400);
    }

    $order->status = $request->status;
    $order->status_order = $this->getStatusOrder($request->status);
    $order->save();

    return response()->json(['message' => 'Order status updated successfully', 'data' => $order]);
}

private function updateOrderStatus($status)
{
    $statusOrders = [
        'preparing' => 1,
        'ready_for_pickup' => 2,
        'completed' => 3,
        // Add more statuses and orders as needed
    ];

    return $statusOrders[$status] ?? 0;
}

}

