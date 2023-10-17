<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class KurirController extends Controller
{
    public function getData()
    {
        $kurirUsers = User::where('role', 'Kurir')->get();
        return response()->json($kurirUsers, 200);
    }

    public function deleteKurir($id)
    {
        $kurir = User::where('role', 'Kurir')->find($id);

        if (!$kurir) {
            return response()->json(['message' => 'Data kurir tidak ditemukan'], 404);
        }

        $kurir->delete();

        return response()->json(['message' => 'Data kurir berhasil dihapus'], 200);
    }
}
