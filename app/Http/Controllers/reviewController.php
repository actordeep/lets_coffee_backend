<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Review;
use App\Models\User;

class ReviewController extends Controller
{
   
public function addReview(Request $request)
{
    // Validation rules
    $request->validate([
        'user_id' => 'required|integer', // Assuming you provide user_id in the request
        'item_id' => 'required|integer',
        'rating' => 'required|integer|min:1|max:5',
        'description' => 'nullable|string',
    ]);

    // Check if the user exists
    $user = User::find($request->user_id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Check if the user has already reviewed the same item
    $existingReview = Review::where('user_id', $user->id)
        ->where('item_id', $request->item_id)
        ->first();

    if ($existingReview) {
        return response()->json(['error' => 'You have already reviewed this item'], 400);
    }

    // Create a new review
    $review = new Review([
        'user_id' => $user->id,
        'item_id' => $request->item_id,
        'rating' => $request->rating,
        'description' => $request->description,
    ]);

    $review->save();

    return response()->json(['message' => 'Review added successfully', 'data' => $review]);
}

    public function getAverageRating($itemType, $itemId)
    {
        $averageRating = Review::where('item_type', $itemType)
            ->where('item_id', $itemId)
            ->avg('rating');

        return response()->json(['average_rating' => $averageRating]);
    }
}

