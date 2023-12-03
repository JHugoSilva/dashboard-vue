<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'password' => bcrypt($request->password)
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

    public function user(Request $request) {
        $id = $request->user()->id;
        $user = User::with(['photos', 'role' => function($q) {
            $q->with(['permissions' => function($q) {
                $q->with('page');
            }]);
        }])->find($id);
        return response()->json([
            'status' => 200,
            'user' => $user
        ]);
    }

    public function resetPass(Request $request) {
        $id = $request->user()->id;
        User::find($id)->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Password Change Success'
        ]);
    }

    public function userUpdate(Request $request) {
        $id = $request->user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($id, 'id')]
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
                
            ], 400);
        }

        User::find($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'father_name' => $request->father_name,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'User Update Success'
        ]);
    }

    public function profileUpload(Request $request) {
        $user = User::find($request->id);
        $file = $request->file('file');
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $file->move('images/users/', $fileName);
        $user->update([
            'photo' => $fileName
        ]);

        Photo::create([
            'user_id' => $request->id,
            'name' => $fileName
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Success Image Upload',
            'path' => $fileName
        ]);
    }

    public function deletePhoto($id) {
        $photo = Photo::find($id);
        $photo->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Success image delete'
        ]);
    }

    public function selectPhoto($id) {
        $photo = Photo::find($id);
        $user = User::find(auth()->user()->id);
        $user->update([
            'photo' => $photo->name
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Success image selected'
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
