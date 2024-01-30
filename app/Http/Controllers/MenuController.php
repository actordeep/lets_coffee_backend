<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; // Make sure to import your Menu model
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function addItem(Request $request)
    {
        // Validation
        //new validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        // Create a new menu item
        $menuItem = Menu::create($request->all());
    
        return response()->json(['message' => 'Item added successfully', 'data' => $menuItem]);
    }

    public function updateItem(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'price' => 'numeric',
            'category' => 'string',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        // Find the menu item
        $menuItem = Menu::findOrFail($id);
    
        // Update the menu item
        $menuItem->update($request->all());
    
        return response()->json(['message' => 'Item updated successfully', 'data' => $menuItem]);
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
            $menuItem = Menu::findOrFail($id);
    
            // Delete the menu item
            $menuItem->delete();
    
            return response()->json(['message' => 'Item deleted successfully']);
        } catch (\Exception $e) {
            // Log the error for further investigation
            \Log::error('Exception: ' . $e->getMessage());
    
            return response()->json(['error' => 'Internal Server Error', 'details' => $e->getMessage()], 500);
        }
    }
}    