<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roti extends Model
{
    use HasFactory;

    protected $table = 'roti';

    protected $fillable = ['nama_roti', 'jenis_roti', 'tanggal_produksi', 'tanggal_kadaluarsa'];

    public function alokasi()
    {
        return $this->hasMany(Alokasi::class, 'alokasi_id');
    }

    public $timestamps = true;
}