<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset; // Fix typo in model name
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Mail\Message;
use Illuminate\Support\Str;

class passwordRersetController extends Controller
{
    public function send_reset_password_email(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if User's Email Exists or Not
        $user = User::where('email', $request->email)->first(); // Fix typo in variable name
        if (!$user) {
            return response([
                'message' => 'Email doesn\'t exist',
                'status' => 'failed'
            ], 404);
        }

        // Generate token
        $token = Str::random(60);

        // Saving Data to Password Reset Table
        PasswordReset::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Additional logic to send the reset password email
        $resetUrl = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(60),
            ['token' => $token, 'email' => $request->email]
        );

        Mail::send('emails.reset_password', ['resetUrl' => $resetUrl], function (Message $message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Your Password');
        });

        return response([
            'message' => 'Reset password email sent successfully',
            'status' => 'success'
        ], 200);
    }
 
}
