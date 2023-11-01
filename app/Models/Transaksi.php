<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    public function alokasi(){
        return $this->belongsTo(Alokasi::class, 'alokasi_id');
    }
}