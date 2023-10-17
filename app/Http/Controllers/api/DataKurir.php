<?php

namespace App\Http\Controllers\Api; // Pastikan namespace sesuai dengan penamaan direktori Anda
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class DataKurir extends Controller{
  public function getData(){
    $kurir = User::where('role', 'Kurir')->get();
    return response()->json($kurir, 200);  
    
  }
}