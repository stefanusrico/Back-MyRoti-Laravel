<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Roti;

class RotiController extends Controller
{
    public function addRoti(Request $request)
    {
        // Validasi data yang diterima dari permintaan
        $validator = Validator::make($request->all(), [
            'nama_roti' => 'required',
            'jenis_roti' => 'required',
            'tanggal_produksi' => 'required',
            'tanggal_kadaluarasa' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $roti = new Roti([
            'nama_roti' => $request->input('nama_roti'),
            'jenis_roti' => $request->input('jenis_roti'),
            'tanggal_produksi' => $request->input('tanggal_produksi'),
            'tanggal_kadaluarasa' => $request->input('tanggal_kadaluarasa'),
        ]);

        

        $roti->save();

        // Kembalikan respon sukses
        return response()->json(['message' => 'Data roti berhasil disimpan'], 201);
    }

    public function getRoti()
    {
        $roti = Roti::all();

        // Mengubah data yang dikembalikan
        $dataRoti = $roti->map(function ($roti) {
            return [
                'id_roti' => $roti->id,
                'nama_roti' => $roti->nama_roti,
                'jenis_roti' => $roti->jenis_roti,
                'tanggal_produksi' => $roti->tanggal_produksi,
                'tanggal_kadaluarasa' => $roti->tanggal_kadaluarasa,
            ];
        });

        return response()->json($dataRoti, 200);
    }

    public function showData($id)
    {
        try{
            $roti = Roti::findOrFail($id);
            return response()->json($roti);
        }
        catch(\Exception $e){
            return response()->json(['message' => 'roti tidak ditemukan'], 404);
        }
    }

    public function updateRoti(Request $request, $id)
    {
        $roti = Roti::find($id);

        if (!$roti) {
            return response()->json(['message' => 'Data roti tidak ditemukan'], 404);
        }

        // Validasi hanya bidang-bidang tertentu yang diizinkan diubah
        $validator = Validator::make($request->all(), [
            'nama_roti' => 'required',
            'jenis_roti' => 'required',
            'tanggal_produksi' => 'required',
            'tanggal_kadaluarasa' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $roti->nama_roti = $request->input('nama_roti');
        $roti->jenis_roti = $request->input('jenis_roti');
        $roti->tanggal_produksi = $request->input('tanggal_produksi');
        $roti->tanggal_kadaluarasa = $request->input('tanggal_kadaluarasa');
        $roti->save();

        return response()->json(['message' => 'Data roti berhasil diperbarui'], 200);
    }

    public function deleteRoti($id)
    {
        $roti = Roti::find($id);

        if (!$roti) {
            return response()->json(['message' => 'Data roti tidak ditemukan'], 404);
        }

        $roti->delete();

        return response()->json(['message' => 'Data roti berhasil dihapus'], 200);
    }

}