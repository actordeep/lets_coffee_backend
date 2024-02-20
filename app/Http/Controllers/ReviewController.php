<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use DB;

class ReviewController extends Controller
{
    public function review(Request $request){
        $request->validate([
            'user_id' => 'required|integer',
            'coffee_shop_id' => 'required|integer', 
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

         $insert = DB::table('reviews')->insert(['user_id'=>$request->user_id,'coffee_shop_id'=>$request->coffee_shop_id,'rating'=>$request->rating,'comment'=>$request->comment]);
         if($insert){
            return 'yes';

         }
         else{
            return 'no';
         }

        // Create a new review
        $review = Review::all();
      return response()->json(['message' => 'Review submitted successfully']);
    }
    
   
    public function index()
    {
        $reviews = Review::all();
        return response()->json(['reviews' => $reviews], 200);
    }

    
    public function store(Request $request)
    {
       
        $request->validate([
            'user_id' => 'required|integer',
            'coffee_shop_id' => 'required|integer',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::create($request->all());

        return response()->json(['review' => $review], 201);
    }

   
    public function show($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        return response()->json(['review' => $review], 200);
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'coffee_shop_id' => 'required|integer',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->update($request->all());

        return response()->json(['review' => $review], 200);
    }

   
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully'], 200);
    }
}
