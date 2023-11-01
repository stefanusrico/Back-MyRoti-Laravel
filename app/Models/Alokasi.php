<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alokasi extends Model
{
    use HasFactory;

    public function koordinator()
    {
        return $this->belongsTo(Koordinator::class, 'koordinator_id');
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