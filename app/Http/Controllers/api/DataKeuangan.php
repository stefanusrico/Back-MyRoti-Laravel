<?php

namespace App\Http\Controllers\Api; // Pastikan namespace sesuai dengan penamaan direktori Anda
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class DataKeuangan extends Controller{
  public function getData(){
    $keuangan = User::where('role', 'Keuangan')->get();
    return response()->json($keuangan, 200);  
    
  }
}