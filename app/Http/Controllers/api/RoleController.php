<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $role = new Role([
            'role_name' => $request->input('role_name'),
        ]);

        $role->save();

        return response()->json(['message' => 'Role stored successful'], 201);
    }
}