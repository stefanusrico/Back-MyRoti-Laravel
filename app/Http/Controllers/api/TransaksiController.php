<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Alokasi;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_alokasi' => 'required',
            'lapak' => 'required|string',
            'jumlah_roti_terjual' => 'required|integer',
            'pendapatan' => 'required|numeric',
            'hutang' => 'required|numeric',
            'catatan' => 'nullable|string',
            'tanggal_transaksi' => 'required|date',
        ]);

        $jumlahRotiAlokasi = Alokasi::findOrFail($request->id_alokasi)->jumlah_roti_alokasi;

        $jumlahRotiTidakTerjual = $jumlahRotiAlokasi - $request->jumlah_roti_terjual;

        $validatedData['jumlah_roti_tidak_terjual'] = max(0, $jumlahRotiTidakTerjual);

        $transaksi = Transaksi::create($validatedData);

        return response()->json(['message' => 'Transaksi created successfully', 'data' => $transaksi], 201);
    }

    public function getData()
    {

        $transaksi = DB::table('transaksi')
            ->select('*')
            ->get();

        return response()->json(['message' => $transaksi], 200);
    }

    public function destroy($id)
    {
        try {
            $transaksi = DB::table('transaksi')->where('id', $id)->delete();
            if ($transaksi) {
                return response()->json(['message' => 'Transaksi deleted sucessfully'], 200);
            } else {
                return response()->json(['message' => 'Transaksi not found'], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting transaksi'], 500);
        }
    }
}