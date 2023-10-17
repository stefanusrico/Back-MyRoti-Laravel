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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/lapak_images', $imageName);
            $lapak->image = $imageName;
        }

        $lapak->save();

        // Kembalikan respon sukses
        return response()->json(['message' => 'Data lapak berhasil disimpan'], 201);
    }

    public function getLapak()
    {
    $lapak = Lapak::all();

    // Mengubah data yang dikembalikan
    $lapakData = $lapak->map(function ($lapak) {
        return [
            'id' => $lapak->id,
            'nama_warung' => $lapak->nama_warung,
            'area' => $lapak->area,
            'alamat_warung' => $lapak->alamat_warung,
            'contact_warung' => $lapak->contact_warung,
            'image' => asset('storage/lapak_images/' . $lapak->image), // Mengembalikan URL gambar
        ];
    });

    // Kembalikan data lapak dalam format JSON
    return response()->json($lapakData, 200);
    }

    public function updateLapak(Request $request, $id)
    {
        $lapak = Lapak::find($id);
    
        if (!$lapak) {
            return response()->json(['message' => 'Data lapak tidak ditemukan'], 404);
        }
    
        // Validasi hanya bidang-bidang tertentu yang diizinkan diubah
        $validator = Validator::make($request->all(), [
            'nama_warung' => 'required',
            'area' => 'required',
            'alamat_warung' => 'required',
            'contact_warung' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $lapak->area = $request->input('area');
        $lapak->alamat_warung = $request->input('alamat_warung');
        $lapak->contact_warung = $request->input('contact_warung');
        $lapak->save();
    
        return response()->json(['message' => 'Data lapak berhasil diperbarui'], 200);
    }    
    
    
    public function deleteLapak($id)
    {
        $lapak = Lapak::find($id);
    
        if (!$lapak) {
            return response()->json(['message' => 'Data lapak tidak ditemukan'], 404);
        }
    
        $lapak->delete();
    
        return response()->json(['message' => 'Data lapak berhasil dihapus'], 200);
    }
    

}