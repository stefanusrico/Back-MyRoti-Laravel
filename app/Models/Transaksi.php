<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = ['id_alokasi', 'tanggal_transaksi', 'jumlah_roti_terjual', 'total_harga'];

    public function alokasi()
    {
        return $this->belongsTo(Alokasi::class);
    }
}