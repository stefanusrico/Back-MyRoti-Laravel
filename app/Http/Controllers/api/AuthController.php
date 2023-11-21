<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pemilik;
use App\Models\Kurir;
use App\Models\Koordinator;
use App\Models\Keuangan;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessTokenFactory;
use Spatie\Permission\Traits\HasRoles;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'id_role' => 'required|in:1,2,3,4,5|numeric|exists:role,id',
            'id_area' => ($request->input('id_role') === 1) ? 'required|exists:area,id' : '',
        ]);

        // Buat pengguna (user) baru
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'password_unhashed' => ($request->input('password')),
            'id_role' => $request->input('id_role'),
        ]);

        $user->save();

        // Berdasarkan peran (role) pengguna, buat entri dalam tabel yang sesuai
        if ($request->input('id_role') == 1) {
            info('id_role is 1');

            $areaId = $request->input('id_area');

            if (!Area::where('id', $areaId)->exists()) {
                $user->delete();
                return response()->json(['message' => 'Invalid id_area'], 400);
            }

            $kurir = new Kurir();
            $kurir->id_area = $areaId;
            $user->kurir()->save($kurir);
        }

        return response()->json(['message' => 'Registration successful'], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Generate a token using Sanctum
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token]);
        }

        return response()->json(['message' => 'Login failed'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}