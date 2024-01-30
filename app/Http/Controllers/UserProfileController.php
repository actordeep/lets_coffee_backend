<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class UserProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        
        if (auth()->user()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|string',
                'password' => 'nullable|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'msg' => $validator->errors()]);
            }

            $user = auth()->user();

            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return response()->json(['success' => true, 'msg' => 'User data updated successfully', 'data' => $user]);
        } else {
            return response()->json(['success' => false, 'msg' => 'User is not authenticated.']);
        }
    }
}
