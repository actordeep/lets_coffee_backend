<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // INDEX

    public function index()
    {
        $inventory = Inventory::all();
        return response()->json($inventory);
    }


    // show

    public function show($id)
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            return response()->json(['error' => 'Inventory item not found.'], 404);
        }

        return response()->json($inventory);
    }


    //  STORE
    public function store(Request $request)
    {
        $inventory = new Inventory($request->all());
        $inventory->save();

        return response()->json($inventory, 201);
    }


    //  UPDATE
    public function update(Request $request, $id)
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            return response()->json(['error' => 'Inventory item not found.'], 404);
        }

        $inventory->update($request->all());

        return response()->json($inventory, 200);
    }


   
    public function destroy($id)
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            return response()->json(['error' => 'Inventory item not found.'], 404);
        }

        $inventory->delete();

        return response()->json(null, 204);
    }
}
