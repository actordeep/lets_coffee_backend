<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;   


class UserController extends Controller
{
       
    // register

    public function register(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'cpassword' => 'required'
        ]);

        // Check if the email already exists in the database
        if (User::where('email', $request->email)->first()) {
            return response([
                'message' => 'Email already exists',
                'status' => 'failed'
            ], 200);
        }
 
        // Check if the provided password matches the password confirmation
        if ($request->password != $request->cpassword) {
            return response([
                'message' => 'Password and password confirmation do not match',
                'status' => 'failed'
            ], 200);
        }

        // Create a new user in the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Respond with a success message
        return response([
            'message' => 'Registration success',
            'status' => 'success'
        ], 201);
    }



//    Login

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $email = $request->email;
    $password = $request->password;

    $auth = Auth::guard(); // Create a new instance of the Auth facade

    if ($auth->attempt(['email' => $email, 'password' => $password])) {
        $user = $auth->user(); // Retrieve the authenticated user
        $token = $user->createToken('authToken')->accessToken;
        return response([
            'status' => 1,
            'message' => 'Login successful',
            'access_token' => $token,

        ], 200);
    } else {
        return response([
            'message' => 'Invalid credentials',
            'status' => 'failed',
        ], 401);
    }
 }

   
//    search

 public function search(Request $request)
 {
    $name = $request->input('name', '');
    // return $name;

    // Use Eloquent to search in the 'coffees' table
    $results = DB::table('coffee')->where('name', 'LIKE', '%' . $name . '%')->get();
    // return $results;

    return response()->json($results);
 }





    // logout

    public function logout(Request $request)
    {
            // Check if the user is authenticated
            if (Auth::check()) {
                
                $request->user()->tokens->each(function ($token, $key) {
                    $token->delete();
                });
               
                // Return a response indicating successful logout
                return response([
                    'message' => 'Logout successful',
                    'data' => $request->user()
                ], 200);
            }
    
            
            return response([
                'message' => 'User not authenticated',
            ], 401);
    }


        // loged_user

        public function loged_user(){
            $logeduser = auth()->user();
            return response([
                'user'=>$logeduser,
                'message'=>'logout user data',
                'stauts'=>'success'
            ],200);
        }
    
    
        
    
}

