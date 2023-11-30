<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {

        $users = User::paginate(10);
        return response()->json([
            'users' => $users
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', Rule::unique('users')]
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
                
            ], 400);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'father_name' => $request->father_name,
            'date_of_birth' => $request->date_of_birth,
            'password' => bcrypt($request->password)

        ]);

        return response()->json([
            'status' => 201,
            'message' => 'User Create Success'
        ]);
    }
}
