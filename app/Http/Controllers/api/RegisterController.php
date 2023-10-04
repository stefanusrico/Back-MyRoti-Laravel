<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required|min:8|confirmed|regex:/[A-Z]/|regex:/[0-9]{3}/'
        ]);

        if ( $validatedData->fails() ) {
            return response()->json($validatedData->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);

        if ( $user ) {
            return response()->json([
                'success' => true,
                'user' => $user,
            ], 201);
        } else {
        return response()->json([
            'success' => false,
        ], 409);
    }
    }
}
