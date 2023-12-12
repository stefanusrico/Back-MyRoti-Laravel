<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = ['id_alokasi', 'lapak', 'jumlah_roti_terjual', 'jumlah_roti_tidak_terjual', 'pendapatan', 'hutang', 'catatan'];

    public function alokasi()
    {
        return $this->belongsTo(Alokasi::class);
    }
}