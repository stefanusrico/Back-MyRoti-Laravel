<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_alokasi' => 'required',
            'lapak' => 'required|string',
            'jumlah_roti_terjual' => 'required|integer',
            'jumlah_roti_tidak_terjual' => 'required|integer',
            'pendapatan' => 'required|numeric',
            'hutang' => 'required|numeric',
            'catatan' => 'nullable|string',
        ]);

        $transaksi = Transaksi::create($validatedData);

        return response()->json(['message' => 'Transaksi created successfully', 'data' => $transaksi], 201);
    }
}