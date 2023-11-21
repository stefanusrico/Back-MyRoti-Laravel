<?php

namespace App\Http\Controllers\api;

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
            'nama_lapak' => 'required|unique:lapak,nama_lapak',
            'id_area' => 'required|exists:area,id',
            'id_kurir' => 'required|exists:kurir,id',
            'alamat' => 'required',
            'contact_lapak' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Simpan data lapak ke dalam basis data
        $lapak = new Lapak([
            'nama_lapak' => $request->input('nama_lapak'),
            'id_area' => $request->input('id_area'),
            'id_kurir' => $request->input('id_kurir'),
            'alamat' => $request->input('alamat'),
            'contact_lapak' => $request->input('contact_lapak'),
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
                'id_lapak' => $lapak->id,
                'nama_lapak' => $lapak->nama_lapak,
                'area' => $lapak->area->nama_area,
                'kurir' => $lapak->kurir->nama_kurir,
                'alamat_lapak' => $lapak->alamat,
                'contact_lapak' => $lapak->contact_lapak,
                'image' => asset('storage/lapak_images/' . $lapak->image),
            ];
        });

        return response()->json($lapakData, 200);
    }

    public function getLapakById($id)
    {
        try {
            $lapak = Lapak::findOrFail($id);

            $lapakData = [
                'id_lapak' => $lapak->id,
                'nama_lapak' => $lapak->nama_lapak,
                'area' => $lapak->area->nama_area,
                'kurir' => $lapak->kurir->nama_kurir,
                'alamat_lapak' => $lapak->alamat,
                'contact_lapak' => $lapak->contact_lapak,
                'image' => asset('storage/lapak_images/' . $lapak->image),
            ];

            return response()->json($lapakData, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lapak tidak ditemukan'], 404);
        }
    }

    public function showData($id)
    {
        try {
            $lapak = Lapak::findOrFail($id);
            return response()->json($lapak);
        } catch (\Exception $e) {
            return response()->json(['message' => 'lapak tidak ditemukan'], 404);
        }
    }

    public function updateLapak(Request $request, $id)
    {
        $lapak = Lapak::find($id);

        if (!$lapak) {
            return response()->json(['message' => 'Data lapak tidak ditemukan'], 404);
        }

        // Validasi hanya bidang-bidang tertentu yang diizinkan diubah
        $validator = Validator::make($request->all(), [
            'id_area' => 'required|exists:area,id',
            'id_kurir' => 'required|exists:kurir,id',
            'alamat' => 'required',
            'contact_lapak' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Update specific attributes
        $lapak->id_kurir = $request->input('id_kurir');
        $lapak->id_area = $request->input('id_area');
        $lapak->alamat = $request->input('alamat');
        $lapak->contact_lapak = $request->input('contact_lapak');

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