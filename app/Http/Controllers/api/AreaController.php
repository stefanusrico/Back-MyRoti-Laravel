<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function getArea(Request $request)
    {
        $area = DB::table('area')->select('id', 'nama_area')->get();
        return response()->json($area);
    }
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

    public function getArea()
    {
        $area = Area::all();

        return response()->json($area, 200);
    }
}