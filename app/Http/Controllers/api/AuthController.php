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
            'username' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required|in:Pemilik,Kurir,Koordinator,Keuangan,Admin',
        ]);

        // Buat pengguna (user) baru
        $user = new User([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'password_unhashed' => ($request->input('password')),
            'role' => $request->input('role'),
        ]);

        $user->save();

        // Berdasarkan peran (role) pengguna, buat entri dalam tabel yang sesuai
        if ($request->input('role') === 'Pemilik') {
            $pemilik = new Pemilik();
            // Isi data pemilik jika ada
            $user->pemilik()->save($pemilik);
        } elseif ($request->input('role') === 'Kurir') {
            $areaId = $request->input('area_id');
                
                // Validasi apakah $areaId sesuai dengan entri yang ada di tabel area
                if (!Area::where('id', $areaId)->exists()) {
                    $user->delete();
                    return response()->json(['message' => 'Invalid area_id'], 400);
                }

            $kurir = new Kurir();
            $kurir->nama_kurir = $user->name;
            $kurir->area_id = $areaId;
            $user->kurir()->save($kurir);
        } elseif ($request->input('role') === 'Koordinator') {
            $koordinator = new Koordinator();
            $koordinator->nama_koordinator = $user->name;
            // Isi data koordinator jika ada
            $user->koordinator()->save($koordinator);
        } elseif ($request->input('role') === 'Keuangan') {
            $keuangan = new Keuangan();
            $keuangan->nama_keuangan = $user->name;
            $user->keuangan()->save($keuangan);
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