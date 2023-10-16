<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function __invoke(Request $request)
  {
    $credentials = $request->only('username', 'password');

    $validator = Validator::make($credentials, [
      'username' => 'required',
      'password' => 'required|regex:/^(?=.*[A-Z])(?=.*[0-9]{3,}).+$/',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => 'Username or password format is invalid.',
      ], 400);
    }

    if (Auth::attempt($credentials)) {
      // Autentikasi berhasil
      $user = Auth::user();
      $role = $user->role;
      return response()->json([
        'success' => true,
        'user' => $user,
        'role' => $role,
      ], 200);
    }

    // Autentikasi gagal
    return response()->json([
      'success' => false,
      'message' => 'Login gagal. Periksa kembali username dan password Anda.',
    ], 401);
  } 
}