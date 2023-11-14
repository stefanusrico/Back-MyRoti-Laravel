<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Lapak;
use App\Models\Area;

class LapakController extends Controller
{
    public function addLapak(Request $request)
    {
        // Validasi data yang diterima dari permintaan
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'nama_lapak' => 'required|unique:lapak',
            'area_id' => 'required',
            'alamat_lapak' => 'required',
            'contact_lapak' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Simpan data lapak ke dalam basis data
        $lapak = new Lapak([
            'nama_lapak' => $request->input('nama_lapak'),
            'area_id' => $request->input('area_id'),
            'alamat_lapak' => $request->input('alamat_lapak'),
            'contact_lapak' => $request->input('contact_lapak'),
            'image' => $request->input('image'),
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
                'alamat_lapak' => $lapak->alamat_lapak,
                'contact_lapak' => $lapak->contact_lapak,
                'image' => asset('storage/lapak_images/' . $lapak->image), // Mengembalikan URL gambar
            ];
        });

        // Kembalikan data lapak dalam format JSON
        // <console class="log">$lapakData</console>
        return response()->json($lapakData, 200);
    }

    public function showData($id)
{
    try {
        $lapak = Lapak::findOrFail($id);

        $select = ['id', 'nama_lapak', 'alamat_lapak', 'area_id', 'contact_lapak', 'image'];
        $lapak = $lapak->select($select)->first();

        $lapak->image = asset('storage/lapak_images/' . $lapak->image);

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
    'area_id' => 'required',
    'alamat_lapak' => 'required',
    'contact_lapak' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Pastikan area_id yang diberikan ada dalam basis data
    $area = Area::find($request->input('area_id'));
    if (!$area) {
        return response()->json(['message' => 'Area tidak ditemukan'], 404);
    }

    $lapak->area_id = $request->input('area_id');
    $lapak->alamat_lapak = $request->input('alamat_lapak');
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