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
                'user_id' => $kurir->id_user,
                'nama_kurir' => $kurir->user->name,
                'area' => $kurir->area->nama_area,

            ];
        });


        return response()->json($kurirData, 200);
    }

    public function showData($id)
    {
        try {
            $kurir = Kurir::where('id', $id)->get();

            if ($kurir->isEmpty()) {
                return response()->json(['message' => 'kurir tidak ada'], 404);
            }

            $kurirData = $kurir->map(function ($kurir) {
                return [
                    'id' => $kurir->id,
                    'user_id' => $kurir->id_user,
                    'nama_kurir' => $kurir->user->name,
                    'area' => $kurir->area->nama_area,

                ];
            });

            return response()->json($kurirData, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'kurir tidak ditemukan'], 404);
        }
    }

    public function showLapak($id)
    {
        try {
            $lapak = DB::table('alokasi')
                ->join('lapak', 'alokasi.id_lapak', '=', 'lapak.id')
                ->join('roti', 'alokasi.id_roti', '=', 'roti.id')
                ->select('alokasi.id as id_alokasi', 'alokasi.keterangan', 'lapak.image', 'lapak.nama_lapak', 'lapak.alamat', 'alokasi.jumlah_roti_alokasi', 'roti.nama_roti')
                ->where('lapak.id_kurir', $id)
                ->get();


            if (!$lapak) {
                return response()->json(['message' => 'No lapak found.'], 404);
            }

            $lapak->transform(function ($lapaks) {
                $lapaks->image_url = asset('storage/lapak_images/' . $lapaks->image);
                return $lapaks;
            });

            return response()->json($lapak);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching data', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateKeteranganLapak($idAlokasi)
    {
        $dataLapak = DB::table('alokasi')
            ->join('lapak', 'alokasi.id_lapak', '=', 'lapak.id')
            ->where('alokasi.id', $idAlokasi)
            ->update(['keterangan' => 'Done']);

        if (!$dataLapak) {
            return response()->json(['message' => 'DataLapak not found'], 404);
        }

        return response()->json(['message' => 'Update successful']);
    }

}