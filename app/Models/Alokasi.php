<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alokasi extends Model
{
    use HasFactory;

    protected $fillable = ['id_roti', 'id_lapak', 'jumlah_roti_alokasi', 'keterangan'];

    protected $table = 'alokasi';



    public function lapak()
    {
        return $this->belongsTo(Lapak::class, 'id_lapak');
    }

    public function roti()
    {
        return $this->belongsTo(Roti::class, 'id_roti');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}