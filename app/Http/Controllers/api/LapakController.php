<?php

namespace App\Http\Controllers\Api; // Pastikan namespace sesuai dengan penamaan direktori Anda
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Lapak;

class LapakController extends Controller
{
    public function addLapak(Request $request)
    {
        // Validasi data yang diterima dari permintaan
        $validator = Validator::make($request->all(), [
            'nama_warung' => 'required|unique:lapak',
            'area' => 'required',
            'alamat_warung' => 'required',
            'contact_warung' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Simpan data lapak ke dalam basis data
        $lapak = new Lapak([
            'nama_warung' => $request->input('nama_warung'),
            'area' => $request->input('area'),
            'alamat_warung' => $request->input('alamat_warung'),
            'contact_warung' => $request->input('contact_warung'),
        ]);
        $lapak->save();

        // Kembalikan respon sukses
        return response()->json(['message' => 'Data lapak berhasil disimpan'], 201);
    }

    public function getLapak()
    {
    // Mengambil semua data lapak dari basis data
    $lapak = Lapak::all();

    // Kembalikan data lapak dalam format JSON
    return response()->json($lapak, 200);
    }

}