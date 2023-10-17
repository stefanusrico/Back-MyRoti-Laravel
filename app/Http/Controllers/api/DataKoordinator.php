<?php

namespace App\Http\Controllers\Api; // Pastikan namespace sesuai dengan penamaan direktori Anda
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class DataKoordinator extends Controller{
  public function getData(){
    $koordinator = User::where('role', 'Koordinator')->get();
    return response()->json($koordinator, 200);  
    
  }
}