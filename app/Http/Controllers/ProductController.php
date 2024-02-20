<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function addItem(Request $request) 
    {
        
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'quantity'=>'required|integer',
             'rate'   =>'required|integer',
            'discount'=>'required|integer',
            'final_price'=>'required|integer',
           'status' => 'required|string',
            
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        
        // Create a new menu item
        $ProductItem = Product::create($request->all());
    
        return response()->json(['message' => 'Item added successfully', 'data' => $ProductItem]);
    }

    public function updateItem(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'image' => 'jpg,png',
            'quantity' => 'integer',
            'rate'=>'integer',
            'discount' => 'integer',
            'final_price' => 'integer',
            'status' => 'string',

        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        // Find the menu item
        $ProductItem = Product::findOrFail($id);
    
        // Update the menu item
        $ProductItem->update($request->all());
    
        return response()->json(['message' => 'Item updated successfully', 'data' => $ProductItem]);
    }
    

    public function deleteItem($id)
    {
        // Validation
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:menus,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        try {
            // Find the menu item
            $ProductItem = Product::findOrFail($id);
    
            // Delete the menu item
            $ProductItem->delete();
    
            return response()->json(['message' => 'Item deleted successfully']);
        } catch (\Exception $e) {
            // Log the error for further investigation
            \Log::error('Exception: ' . $e->getMessage());
    
            return response()->json(['error' => 'Internal Server Error', 'details' => $e->getMessage()], 500);
        }
    }
}