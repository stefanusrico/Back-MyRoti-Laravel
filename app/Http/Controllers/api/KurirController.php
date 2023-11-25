<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Kurir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KurirController extends Controller
{
    public function namaKurir(Request $request)
    {
        $kurir = DB::table('users')->select(['id', 'name'])->where('id', 1)->first();
        return response()->json($kurir);
    }

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


    public function getKurir()
    {
        $kurir = Kurir::all();

        // Mengubah data yang dikembalikan
        $kurirData = $kurir->map(function ($kurir) {
            return [
                'id' => $kurir->id,
                'user_id' => $kurir->user_id,
                'nama_kurir' => $kurir->nama_kurir,
                'area' => $kurir->area->nama_area,

            ];
        });

        // Kembalikan data lapak dalam format JSON
        // <console class="log">$lapakData</console>
        return response()->json($kurirData, 200);
    }

    public function showData($id)
    {
<<<<<<< Updated upstream
        try{
            $kurir = Kurir::where('id', $id)->get();
            
            if ($kurir->isEmpty()) {
                return response()->json(['message' => 'kurir tidak ada'], 404);
            }

            $kurirData = $kurir->map(function ($kurir) {
                return [
                    'id' => $kurir->id,
                    'user_id' => $kurir->user_id,
                    'nama_kurir' => $kurir->nama_kurir,
                    'area' => $kurir->area->nama_area,
                    
                ];
            });
    
            return response()->json($kurirData, 200);
        }
        catch(\Exception $e){
=======
        try {
            $kurir = Kurir::findOrFail($id);
            return response()->json($kurir);
        } catch (\Exception $e) {
>>>>>>> Stashed changes
            return response()->json(['message' => 'kurir tidak ditemukan'], 404);
        }
    }
}