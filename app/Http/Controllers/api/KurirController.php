<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Kurir;
use Illuminate\Http\Request;

class KurirController extends Controller
{
    public function getKurirByArea(Request $request)
    {
        // Validasi request, misalnya pastikan request memiliki parameter 'lapak_id'
        $request->validate([
            'lapak_id' => 'required|integer', // Gantilah sesuai kebutuhan
        ]);

        $lapakId = $request->input('lapak_id');

        // Query untuk mengambil daftar kurir yang berada di area lapak
        $kurir = Kurir::where('area_id', $lapakId)->get();

        return response()->json($kurir);
    }
}