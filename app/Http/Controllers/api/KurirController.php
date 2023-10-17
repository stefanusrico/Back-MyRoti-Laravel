<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class KurirController extends Controller
{
    public function getData(){
        $kurirUsers = User::where('role', 'Kurir')->get();
        return response()->json($kurirUsers, 200);
    }
}
