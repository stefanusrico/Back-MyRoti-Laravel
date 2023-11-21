<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alokasi extends Model
{
    use HasFactory;

    protected $fillable = ['id_lapak', 'id_roti', 'jumlah_roti_alokasi'];

    protected $table = 'alokasi';



    public function lapak()
    {
        return $this->belongsTo(Lapak::class);
    }

    public function roti()
    {
        return $this->belongsTo(Roti::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}