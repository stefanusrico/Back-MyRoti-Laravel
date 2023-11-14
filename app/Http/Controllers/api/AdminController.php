<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Keuangan;
use App\Models\Koordinator;
use App\Models\Kurir;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function getAmountUser(){
        $jumlahUser = User::count();

        return response()->json($jumlahUser);
    }
    
    public function getAmountKoordinator(){
        $jumlahKoordinator = Koordinator::count();

        return response()->json($jumlahKoordinator);
    }

    public function updateKoordinator(Request $request, $id) {
    try {
        $koordinator = Koordinator::find($id);

        if (!$koordinator) {
            return response()->json(['message' => 'Koordinator not found'], 404);
        }

        $validatedData = $request->validate([
            'nama_koordinator' => 'required|string',
        ]);

        // Perbarui data Kurir
        $koordinator->update($validatedData);

        return response()->json(['message' => 'Koordinator updated successfully']);
    } catch (Exception $e) {
        return response()->json(['message' => 'Error updating Koordinator'], 500);
    }
}

    public function getDataKoordinator() {
    $koordinators = Koordinator::with('user')->get();

    $data = [];

    foreach ($koordinators as $koordinator) {
        $data[] = [
            'id' => $koordinator->id,
            'name' => $koordinator->user->name,
            'username' => $koordinator->user->username,
            'password' => ($koordinator->user->password_unhashed),
            'role' => $koordinator->user->role,
        ];
    }

    return response()->json($data);
    }

    public function deleteKoordinator($id){
    $koordinator = Koordinator::find($id);

    if (!$koordinator) {
        return response()->json(['message' => 'Koordinator not found'], 404);
    }

    $koordinator->delete();


    return response()->json(['message' => 'Koordinator deleted successfully'], 200);
}

    public function getAmountKeuangan(){
        $jumlahKeuangan = Keuangan::count();

        return response()->json($jumlahKeuangan);
    }

    public function updateKeuangan(Request $request, $id) {
    try {
        $keuangan = Keuangan::find($id);

        if (!$keuangan) {
            return response()->json(['message' => 'Keuangan not found'], 404);
        }

        $validatedData = $request->validate([
            'nama_keuangan' => 'required|string',
        ]);

        // Perbarui data Kurir
        $keuangan->update($validatedData);

        return response()->json(['message' => 'Keuangan updated successfully']);
    } catch (Exception $e) {
        return response()->json(['message' => 'Error updating Keuangan'], 500);
    }
}

    public function getDataKeuangan() {
    $keuangans = Keuangan::with('user')->get();

    $data = [];

    foreach ($keuangans as $keuangan) {
        $data[] = [
            'id' => $keuangan->id,
            'name' => $keuangan->user->name,
            'username' => $keuangan->user->username,
            'password' => ($keuangan->user->password_unhashed),
            'role' => $keuangan->user->role,
        ];
    }

    return response()->json($data);
    }

    public function deleteKeuangan($id){
    $keuangan = Keuangan::find($id);

    if (!$keuangan) {
        return response()->json(['message' => 'Keuangan not found'], 404);
    }

    $keuangan->delete();

    return response()->json(['message' => 'Keuangan deleted successfully'], 200);
}

    public function getAmountKurir(){
        $jumlahKurir = Kurir::count();

        return response()->json($jumlahKurir);
    }

public function getDataKurir() {
    Kurir::forgetCache();

    $kurirs = Kurir::with('user')->get();

    $data = [];

    foreach ($kurirs as $kurir) {
        $data[] = [
            'id' => $kurir->id,
            'name' => $kurir->user->name,
            'username' => $kurir->user->username,
            'password' => ($kurir->user->password_unhashed),
            'role' => $kurir->user->role,
            'area_id' => $kurir->area_id,
        ];
    }  

    return response()->json($data);
}


    public function getDataKurirById($id)
{
    // Validasi ID, misalnya pastikan ID adalah bilangan bulat
    if (!is_numeric($id)) {
        return response()->json(['message' => 'Invalid ID'], 400);
    }

    // Query untuk mengambil data kurir berdasarkan ID
    $kurir = Kurir::find($id);

    if (!$kurir) {
        return response()->json(['message' => 'Kurir not found'], 404);
    }

    return response()->json($kurir);
}


public function deleteKurir($id){
    try {
        $kurir = Kurir::find($id);

        if (!$kurir) {
            return response()->json(['message' => 'Kurir not found'], 404);
        }

        $kurir->delete();

        return response()->json(['message' => 'Kurir deleted successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error deleting Kurir', 'error' => $e->getMessage()], 500);
    }
}


public function updateKurir(Request $request, $id) {
    try {
        $kurir = Kurir::find($id);

        if (!$kurir) {
            return response()->json(['message' => 'Kurir not found'], 404);
        }

        $validatedData = $request->validate([
            'nama_kurir' => 'required|string',
            'area_id' => 'required',
        ]);

        // Perbarui data Kurir
        $kurir->update($validatedData);
        $user = $kurir->user;
        $user->name = $validatedData['nama_kurir'];
        $user->save();

        return response()->json(['message' => 'Kurir updated successfully']);
    } catch (Exception $e) {
        return response()->json(['message' => 'Error updating Kurir'], 500);
    }
}

public function updateKurirPassword(Request $request, $id){
    try{
        $kurir = Kurir::find($id);
        
        if (!$kurir) {
            return response()->json(['message' => 'Kurir not found'], 404);
        }

        $validatedData = $request->validate([
            'password' => 'required|string',
        ]);

        $encryptedPassword = Hash::make($validatedData['password']);
        $unhashedPassword = ($validatedData['password']);
        $kurir->user->password = $encryptedPassword;
        $kurir->user->password_unhashed = $unhashedPassword;
        $kurir->user->save();

        
       return response()->json(['message' => 'Kurir password updated successfully']);

    }catch(Exception $e){
        return response()->json(['message' => 'Error updating Kurir password'], 500);
    }
}

public function updateUserPassword(Request $request, $id) {
    try {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            'password' => 'required|string',
        ]);

        // Enkripsi password baru sebelum menyimpannya
        $encryptedPassword = Hash::make($validatedData['password']);
        $unhashedPassword = ($validatedData['password']);
        $user->password = $encryptedPassword;
        $user->password_unhashed = $unhashedPassword;
        $user->save();

        return response()->json(['message' => 'User password updated successfully']);
    } catch (Exception $e) {
        return response()->json(['message' => 'Error updating user password'], 500);
    }
}


// public function updateUser(Request $request, $id)
// {
//     try {
//         $user = User::find($id);

//         if (!$user) {
//             return response()->json(['message' => 'User not found'], 404);
//         }

//         $validatedData = $request->validate([
//             'name' => 'required|string',
//             'username' => 'required|string',
//             'role' => 'string', // Jadikan 'role' sebagai opsi
//         ]);

//         // Update data pengguna (User)
//         $user->fill($validatedData);
//         $user->save();

//         // Anda dapat memisahkan pembaruan data berdasarkan peran (role) di bawah ini
//         if (isset($validatedData['role'])) {
//             if ($validatedData['role'] === 'Koordinator') {
//                 $koordinator = Koordinator::where('user_id', $user->id)->first();

//                 if ($koordinator) {
//                     $koordinator->nama_koordinator = $validatedData['name'];
//                     $koordinator->save();
//                 }
//             }

//             if ($validatedData['role'] === 'Keuangan') {
//                 $keuangan = Keuangan::where('user_id', $user->id)->first();

//                 if ($keuangan) {
//                     $keuangan->nama_keuangan = $validatedData['name'];
//                     $keuangan->save();
//                 }
//             }

//             if ($validatedData['role'] === 'Kurir') {
//                 $kurir = Kurir::where('user_id', $user->id)->first();

//                 if ($kurir) {
//                     $kurir->nama_kurir = $validatedData['name'];

//                     if ($request->has('area_id')) {
//                         $kurir->area_id = $request->input('area_id');
//                     }
//                     $kurir->save();
//                 }
//             }
//         }

//         return response()->json(['message' => 'User updated successfully']);
//     } catch (Exception $e) {
//         return response()->json(['message' => 'Error updating User'], 500);
//     }
// }


}