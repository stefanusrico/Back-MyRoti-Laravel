<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required|string|max:255|unique:area',
        ]);

        Area::create([
            'nama_area' => $request->input('nama_area'),
        ]);

        return response()->json(['message' => 'Data Area berhasil disimpan'], 201);
    }
}