<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Koordinator;

class AdminController extends Controller
{
    public function getDataKoordinator(){
        $koordinator = Koordinator::all();
        return response()->json($koordinator);
    }
}