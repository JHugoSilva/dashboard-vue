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

        $users = User::with(['role'])->paginate(10);
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
                'errors' => $validator->errors()->all()
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

    public function update(Request $request, $id) {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($id)]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'father_name' => $request->father_name,
            'date_of_birth' => $request->date_of_birth,
            'password' => bcrypt($request->password)

        ]);

        return response()->json([
            'status' => 200,
            'message' => 'User Update Success'
        ]);
    }
}
