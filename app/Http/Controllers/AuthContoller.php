<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthContoller extends Controller
{
    
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()->all()
                
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        $token = $user->createToken('AUTH_TOKEN')->plainTextToken;

        return response()->json([
            'status' => 200,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }

    public function login(Request $request) {
        $credentials = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($credentials->fails()) {
            return response()->json([
                $credentials->errors()
            ], 401);
        }

        if (!$token = auth()->attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = auth()->user();

        $token = $user->createToken('AUTH_TOKEN')->plainTextToken;

        return response()->json([
            'status' => 200,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200);
    }

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid email format'
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'We cant find a user with that e-mail address.'
            ], 400);
        }

        $token = $user->createToken('AUTH_TOKEN')->plainTextToken;

        $to_email = $request->email;
        $subject = 'Reset Password Notification';
        $from_email = 'app@email.com';
        $name = $user->name;

        $data = ['name' => $name, 'token' => $token];

        Mail::send('emails.mail', $data, function($message) use($to_email, $subject, $from_email) {
            $message->to($to_email)->subject($subject);
            $message->from($from_email);
        });

        return response()->json([
            'status' => 200,
            'message' => 'Email Sent'
        ]);
    }

    public function logout() {

        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Tokens Revoked'
        ]);
    }
}
