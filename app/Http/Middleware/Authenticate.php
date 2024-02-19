<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        $auth = Auth::guard();

        if ($auth->attempt(['email' => $email, 'password' => $password])) {
            return $next($request);
        }

        return response([
            'message' => 'Invalid credentials',
            'status' => 'failed',
        ], 401);
    }
    
}
