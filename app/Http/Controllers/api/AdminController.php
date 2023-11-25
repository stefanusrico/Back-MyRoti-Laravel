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
    public function getAmountUser()
    {
        $jumlahUser = User::count();

        return response()->json($jumlahUser);
    }

    public function getAmountKoordinator()
    {
        $jumlahKoordinator = DB::table('users')
            ->join('role', 'users.id_role', '=', 'role.id')
            ->where('users.id_role', 3)
            ->count();

        return response()->json($jumlahKoordinator);
    }

    public function getDataKoordinator()
    {
        $koordinators = DB::table('users')
            ->join('role', 'users.id_role', '=', 'role.id')
            ->select('users.id', 'users.name', 'users.email', 'users.password_unhashed', 'role.role_name as role')
            ->where('users.id_role', 3)
            ->get();

        return response()->json($koordinators);
    }

    public function deleteKoordinator($id)
    {
        try {
            $koordinator = DB::table('users')->where('id', $id)->where('id_role', 3)->delete();

            if ($koordinator) {
                return response()->json(['message' => 'Koordinator deleted sucessfully'], 200);
            } else {
                return response()->json(['message' => 'Koordinator not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting Koordinator'], 500);
        }
    }

    public function getDataKoordinatorById($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['message' => 'Invalid ID'], 400);
        }

        $koordinator = DB::table('users')->where('id', $id)->select('users.name', 'users.password_unhashed')->where('id_role', 3)->get();

        if (!$koordinator) {
            return response()->json(['message' => 'Koordinator not found'], 404);
        }

        return response()->json($koordinator);
    }

    public function updateKoordinator(Request $request, $id)
    {
        try {
            $koordinator = DB::table('users')->where('id', $id)->where('id_role', 3)->first();

            if (!$koordinator) {
                return response()->json(['message' => 'Koordinator not found'], 404);
            }

            $validatedData = $request->validate([
                'name' => 'required|string',
            ]);

            DB::table('users')->where('id', $id)->where('id_role', 3)->update(['name' => $validatedData['name']]);

            return response()->json(['message' => 'Koordinator updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating Koordinator', 'error' => $e->getMessage()], 500);
        }
    }


    public function updateKoordinatorPassword(Request $request, $id)
    {
        try {
            $koordinator = DB::table('users')->where('id', $id)->where('id_role', 3)->first();

            if (!$koordinator) {
                return response()->json(['message' => 'Koordinator not found'], 404);
            }

            $validatedData = $request->validate([
                'password_unhashed' => 'required|string',
            ]);

            info($validatedData['password_unhashed']);

            DB::table('users')->where('id', $id)->where('id_role', 3)->update([
                'password' => Hash::make($validatedData['password_unhashed']),
                'password_unhashed' => $validatedData['password_unhashed']
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => 'Error updating Koordinator password'], 500);
        }
    }

    public function getAmountKeuangan()
    {
        $jumlahKeuangan = DB::table('users')
            ->join('role', 'users.id_role', '=', 'role.id')
            ->where('users.id_role', 4)
            ->count();
        ;

        return response()->json($jumlahKeuangan);
    }

    public function updateKeuangan(Request $request, $id)
    {
        try {
            $keuangan = DB::table('users')->where('id', $id)->where('id_role', 4)->first();


            if (!$keuangan) {
                return response()->json(['message' => 'Keuangan not found'], 404);
            }

            $validatedData = $request->validate([
                'name' => 'required|string',
            ]);

            DB::table('users')->where('id', $id)->where('id_role', 4)->update(['name' => $validatedData['name']]);

            return response()->json(['message' => 'Keuangan updated successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error updating Keuangan'], 500);
        }
    }

    public function updateKeuanganPassword(Request $request, $id)
    {
        try {
            $keuangan = DB::table('users')->where('id', $id)->where('id_role', 4)->first();

            if (!$keuangan) {
                return response()->json(['message' => 'Keuangan not found'], 404);
            }

            $validatedData = $request->validate([
                'password_unhashed' => 'required|string',
            ]);

            DB::table('users')->where('id', $id)->where('id_role', 4)->update([
                'password' => Hash::make($validatedData['password_unhashed']),
                'password_unhashed' => $validatedData['password_unhashed']
            ]);

        } catch (Exception $e) {
            return response()->json(['message' => 'Error updating Keuangan password'], 500);
        }
    }

    public function getDataKeuangan()
    {
        $keuangan = DB::table('users')
            ->join('role', 'users.id_role', '=', 'role.id')
            ->select('users.id', 'users.name', 'users.email', 'users.password_unhashed', 'role.role_name as role')
            ->where('users.id_role', 4)
            ->get();
        ;

        return response()->json($keuangan);
    }

    public function getDataKeuanganById($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['message' => 'Invalid ID'], 400);
        }

        $keuangan = DB::table('users')->where('id', $id)->select('users.name', 'users.password_unhashed')->where('id_role', 4)->get();

        if (!$keuangan) {
            return response()->json(['message' => 'Keuangan not found'], 404);
        }

        return response()->json($keuangan);
    }

    public function deleteKeuangan($id)
    {
        try {
            $keuangan = DB::table('users')->where('id', $id)->where('id_role', 4)->delete();

            if ($keuangan) {
                return response()->json(['message' => 'Keuangan deleted sucessfully'], 200);
            } else {
                return response()->json(['message' => 'Keuangan not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting Keuangan'], 500);
        }
    }

    public function getAmountKurir()
    {
        $jumlahKurir = Kurir::count();

        return response()->json($jumlahKurir);
    }

    public function getDataKurir()
    {
        $kurir = DB::table('users')
            ->join('role', 'users.id_role', '=', 'role.id')
            ->select('users.id', 'users.name', 'users.email', 'users.password_unhashed', 'role.role_name as role')
            ->where('users.id_role', 1)
            ->get();

        return response()->json($kurir);
    }

    public function getDataKurirById($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['message' => 'Invalid ID'], 400);
        }

        $kurir = Kurir::with('area', 'user')->where('id_user', $id)->first();

        if (!$kurir) {
            return response()->json(['message' => 'Kurir not found'], 404);
        }

        $name = $kurir->user->name;
        $email = $kurir->user->email;
        $password = $kurir->user->password_unhashed;

        return response()->json([
            'id' => $kurir->id,
            'id_user' => $kurir->id_user,
            'id_area' => $kurir->id_area,
            'email' => $email,
            'name' => $name,
            'password' => $password,
            'area' => $kurir->area,
        ]);
    }



    public function deleteKurir($id)
    {
        try {
            $kurir = DB::table('users')->where('id', $id)->where('id_role', 1)->delete();

            if ($kurir) {
                return response()->json(['message' => 'Kurir deleted sucessfully'], 200);
            } else {
                return response()->json(['message' => 'Kurir not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting Kurir', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateKurir(Request $request, $id)
    {
        try {
            $kurir = DB::table('users')->where('id', $id)->where('id_role', 1)->first();


            if (!$kurir) {
                return response()->json(['message' => 'Kurir not found'], 404);
            }

            $validatedData = $request->validate([
                'name' => 'required|string',
                'id_area' => 'required|numeric',
            ]);

            DB::table('users')
                ->where('id', $id)
                ->where('id_role', 1)
                ->update([
                    'name' => $validatedData['name'],
                ]);

            DB::table('kurir')
                ->where('id_user', $id)
                ->update(['id_area' => $validatedData['id_area']]);

            return response()->json(['message' => 'Kurir updated successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error updating Kurir'], 500);
        }
    }

    public function updateKurirPassword(Request $request, $id)
    {
        try {
            $kurir = DB::table('users')->where('id', $id)->where('id_role', 1)->first();

            if (!$kurir) {
                return response()->json(['message' => 'Kurir not found'], 404);
            }

            $validatedData = $request->validate([
                'password_unhashed' => 'required|string',
            ]);

            info($validatedData['password_unhashed']);

            DB::table('users')->where('id', $id)->where('id_role', 1)->update([
                'password' => Hash::make($validatedData['password_unhashed']),
                'password_unhashed' => $validatedData['password_unhashed']
            ]);


            return response()->json(['message' => 'Kurir password updated successfully']);

        } catch (Exception $e) {
            return response()->json(['message' => 'Error updating Kurir password'], 500);
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