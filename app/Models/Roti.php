<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roti extends Model
{
    use HasFactory;

    protected $table = 'roti';

    protected $fillable = ['nama_roti', 'jenis_roti', 'tanggal_produksi', 'tanggal_kadaluarasa'];

    public function alokasi()
    {
        return $this->hasMany(Alokasi::class);
    }

    public $timestamps = true;
}