<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roti extends Model
{
    use HasFactory;
    
    protected $table = 'roti'; // Nama tabel dalam database

    protected $fillable = ['nama_roti', 'jenis_roti','tanggal_produksi', 'tanggal_kadaluarasa']; // Kolom-kolom yang bisa diisi


    public function alokasi()
    {
        return $this->hasMany(Alokasi::class, 'alokasi_id');
    }

    public $timestamps = true;
}