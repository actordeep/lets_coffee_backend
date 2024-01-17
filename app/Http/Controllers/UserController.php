<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
       
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'cpassword' => 'required'
        ]);

        
        if (User::where('email', $request->email)->first()) {
            return response([
                'message' => 'Email already exists',
                'status' => 'failed'
            ], 200);
        }

        
        if ($request->password != $request->cpassword) {
            return response([
                'message' => 'Password and password confirmation do not match',
                'status' => 'failed'
            ], 200);
        }

        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

       
        return response([
            'message' => 'Registration success',
            'status' => 'success'
        ], 201);
    }
    
// 

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken($request->email)->plainTextToken;
    
            return response()->json([
                'token' => $token,
                'message' => 'Login success',
                'status' => 'success'
            ], 200);
        }
    
        return response()->json([
            'message' => 'The provided credentials are incorrect',
            'status' => 'failed'
        ], 401);
    }

//

    public function logout(){

    auth()->user()->tokens()->delete();

    return response([
        'message' => 'Logout Success',
        'status' => 'Success'
    ], 200);
}

//

public function logged_user(){

    $loggeduser = auth()->user();

    return response([
        'user' => $loggeduser,
        'message' => 'Logout User Data',
        'status' => 'Success'
    ], 200);
}

//

public function change_password(Request $request)
{
    $request->validate([
        'password' => 'required',
        'cpassword' => 'required|same:password', 
    ]);

    $loggedUser = auth()->user();
    $loggedUser->password = Hash::make($request->password);
    $loggedUser->save();

    

    return response([
        'message' => 'Password changed successfully',
        'status' => 'success'
    ], 200);
}
}