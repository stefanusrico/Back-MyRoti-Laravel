<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Alokasi;



class AlokasiController extends Controller
{
   
    public function addAlokasi(Request $request)
    {
        // Validasi data yang diterima dari permintaan
        $validator = Validator::make($request->all(), [
            'koordinator_id' => 'required',
            'kurir_id' => 'required',
            'roti_id' => 'required',
            'jumlah_roti_alokasi' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $alokasi = new Alokasi([
            'koordinator_id' => $request->input('koordinator_id'),
            'kurir_id' => $request->input('kurir_id'),
            'roti_id' => $request->input('roti_id'),
            'jumlah_roti_alokasi' => $request->input('jumlah_roti_alokasi'),
        ]);

        

        $alokasi->save();

        // Kembalikan respon sukses
        return response()->json(['message' => 'Data alokasi berhasil disimpan'], 201);
    }




    public function getAlokasi()
    {
        $alokasi = Alokasi::all();

        // Mengubah data yang dikembalikan
        $dataAlokasi = $alokasi->map(function ($alokasi) {
            return [
                'id' => $alokasi->id,
                'nama_koordinator' => $alokasi->koordinator->nama_koordinator,
                'nama_kurir' => $alokasi->kurir->nama_kurir,
                'roti_id' => $alokasi->roti->nama_roti,
                'jumlah_roti' => $alokasi->jumlah_roti_alokasi,

            ];
        });

        return response()->json($dataAlokasi, 200);
    }

    
}