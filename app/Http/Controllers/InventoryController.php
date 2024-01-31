<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Menu;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::all();
        return response()->json(['data' => $inventory]);
    }

    public function addItem(Request $request)
{
    $request->validate([
        'item_name' => 'required|string',
        'quantity' => 'required|integer',
    ]);

    $inventoryItem = Inventory::where('item_name', $request->item_name)->first();

    if ($inventoryItem) {
        // If the item already exists, update its quantity
        $inventoryItem->quantity += $request->quantity;
        $inventoryItem->save();

        return response()->json(['message' => 'Item quantity updated successfully', 'data' => $inventoryItem]);
    }

    // If the item doesn't exist, create a new inventory item
    $newInventoryItem = Inventory::create($request->all());

    return response()->json(['message' => 'Item added successfully', 'data' => $newInventoryItem]);
}


    public function buyItem(Request $request)
{
    $request->validate([
        'product_name' => 'required|string',
        'quantity' => 'required|integer|min:1',
    ]);

    $inventoryItem = Inventory::where('item_name', $request->product_name)->first();

    if (!$inventoryItem) {
        return response()->json(['message' => 'Inventory item not found'], 404);
    }

    $requiredQuantity = $request->quantity;

    if ($inventoryItem->quantity < $requiredQuantity) {
        return response()->json(['message' => 'Insufficient quantity in the inventory'], 400);
    }

    $inventoryItem->quantity -= $requiredQuantity;
    $inventoryItem->save();

    return response()->json(['message' => 'Item bought successfully']);
}


    // Implement other methods (update, delete) as needed
}
