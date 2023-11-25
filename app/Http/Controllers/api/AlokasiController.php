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
            'id_roti' => 'required',
            'id_lapak' => 'required',
            'jumlah_roti_alokasi' => 'required',
            'keterangan' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $alokasi = new Alokasi([
            'id_roti' => $request->input('id_roti'),
            'id_lapak' => $request->input('id_lapak'),
            'jumlah_roti_alokasi' => $request->input('jumlah_roti_alokasi'),
            'keterangan' => $request->input('keterangan'),
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
                'lapak' => $alokasi->lapak->nama_lapak,
                'kurir' => $alokasi->lapak->kurir->user->name,
                'roti_id' => $alokasi->roti->nama_roti,
                'jumlah_roti' => $alokasi->jumlah_roti_alokasi,
                'keterangan' => $alokasi->keterangan,

            ];
        });

        return response()->json($dataAlokasi, 200);
    }


    public function getAlokasiByLapak($id)
    {
        try{
            $lapak_id = $id; // Ganti dengan nilai lapak_id yang sesuai
        
            $alokasi = Alokasi::where('id_lapak', $lapak_id)->get();
            if ($alokasi->isEmpty()) {
                return response()->json(['message' => 'Alokasi kosong'], 404);
            }
    
            // Format data menggunakan metode map
            $dataAlokasi = $alokasi->map(function ($item) {
                return [
                    'id' => $item->id,
                    'lapak' => $item->lapak->nama_lapak,
                    'kurir' => $item->lapak->kurir->user->name,
                    'roti_id' => $item->roti->nama_roti,
                    'jumlah_roti' => $item->jumlah_roti_alokasi,
                    'keterangan' => $item->keterangan,
                ];
            });
    
            return response()->json($dataAlokasi, 200);
        }
        catch(\Exception $e){
            return response()->json(['message' => 'alokasi tidak ada'], 404);
        }
    }

    public function getAlokasiByKeterangan($id)
    {
        try{
            $lapak_id = $id; // Ganti dengan nilai lapak_id yang sesuai
        
            $alokasi = Alokasi::where('id_lapak', $lapak_id)
                                ->where('keterangan', 'In Progress')
                                ->get();
            if ($alokasi->isEmpty()) {
                return response()->json(['message' => 'Alokasi kosong'], 404);
            }
    
            // Format data menggunakan metode map
            $dataAlokasi = $alokasi->map(function ($item) {
                return [
                    'id' => $item->id,
                    'lapak' => $item->lapak->nama_lapak,
                    'kurir' => $item->lapak->kurir->user->name,
                    'id_roti' => $item->roti->nama_roti,
                    'jumlah_roti' => $item->jumlah_roti_alokasi,
                    'keterangan' => $item->keterangan,
                ];
            });
    
            return response()->json($dataAlokasi, 200);
        }
        catch(\Exception $e){
            return response()->json(['message' => 'alokasi tidak ada'], 404);
        }
    }


    public function updateKeteranganAlokasi(Request $request, $id)
    {
        $alokasi = Alokasi::find($id);

        if (!$alokasi) {
            return response()->json(['message' => 'Data alokasi tidak ada'], 404);
        }

        
        $validator = Validator::make($request->all(), [
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $alokasi->keterangan = $request->input('keterangan');
        $alokasi->save();

        return response()->json(['message' => 'Data alokasi berhasil diperbarui'], 200);
    }


    public function deleteAlokasi($id)
    {
        $alokasi = Alokasi::find($id);

        if (!$alokasi) {
            return response()->json(['message' => 'Data alokasi tidak ditemukan'], 404);
        }

        $alokasi->delete();

        return response()->json(['message' => 'Data alokasi dengan id ', $id ,'berhasil dihapus'], 200);
    }


    
}