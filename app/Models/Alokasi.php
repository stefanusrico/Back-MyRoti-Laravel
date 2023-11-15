<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alokasi extends Model
{
    use HasFactory;

    protected $fillable = ['lapak_id', 'kurir_id', 'roti_id', 'jumlah_roti_alokasi'];

    protected $table = 'alokasi';

    public function lapak()
    {
        return $this->belongsTo(Lapak::class, 'lapak_id');
    }

    public function kurir()
    {
        return $this->belongsTo(Kurir::class, 'kurir_id');
    }

    public function roti()
    {
        return $this->belongsTo(Roti::class, 'roti_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}

// 