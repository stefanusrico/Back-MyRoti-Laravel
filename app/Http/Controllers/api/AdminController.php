<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Keuangan;
use App\Models\Koordinator;
use App\Models\Kurir;

class AdminController extends Controller
{
    public function getDataKoordinator() {
    $koordinators = Koordinator::with('user')->get();

    return response()->json($koordinators);
    }

    public function getDataKeuangan() {
    $keuangan = Keuangan::with('user')->get();

    return response()->json($keuangan);
    }

    public function getDataKurir() {
    $kurir = Kurir::with('user')->get();

    return response()->json($kurir);
    }
}