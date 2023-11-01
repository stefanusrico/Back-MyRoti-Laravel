<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapak extends Model
{
    use HasFactory;

    protected $fillable = ['nama_lapak', 'alamat_lapak', 'contact_lapak', 'image', 'area_id'];

    protected $table = 'lapak';


    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function kurir()
    {
        return $this->hasOne(Kurir::class, 'kurir_id');
    }
}