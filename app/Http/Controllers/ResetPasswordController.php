<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Mail\Message;

// class ResetPasswordController extends Controller
// {
//     public function send_reset_password_email(Request $request)
//     {
//         $request->validate([
//             'email' => 'required|email',
//         ]);

//         $email = $request->email;

        // Check if User's Email Exists or Not
        // $user = User::where('email', $email)->first();
        // if (!$user) {
        //     return response([
        //         'message' => 'Email doesn\'t exist',
        //         'status' => 'failed'
        //     ], 404);
        // }

        // Generate token
        // $token = Str::random(60);

        // Saving Data to Password Reset Table
        // PasswordReset::create([
        //     'email' => $email,
        //     'token' => $token,
        //     'created_at' => Carbon::now(),
        // ]);

        // Generating the password reset link
        $resetUrl = url("/api/user/reset/{$token}");

        // Sending email with password reset instructions
        // Mail::send([], [], function (Message $message) use ($request, $resetUrl) {
        //     $message->to($request->email)
        //         ->subject('Reset Your Password')
        //         ->setBody(view('reset', ['token' => $token, 'resetUrl' => $resetUrl])->render(), 'text/html');
        // });

        // Sending the link in the API response
//         return response([
// //             'message' => 'Password reset email sent. Check your email for instructions.',
// //             'status' => 'success',
// //             'reset_link' => $resetUrl,
// //         ], 200);
// //     }
// // }
