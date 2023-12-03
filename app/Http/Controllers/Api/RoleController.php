<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->get();

        return response()->json([
            'message' => 'success get roles',
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
        ]);

        Role::create([
            'name_role' => $request->name,
        ]);

        return response()->json([
            'message' => 'Role create successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_role' => [
                'required',
                Rule::unique('roles')->ignore($id, 'id')
            ]
        ]);

        $page = Role::find($id);

        $page->update([
            'name_role' => $request->name_role
        ]);

        return response()->json([
            'message' => 'Role update successfully'
        ]);
    }
}
