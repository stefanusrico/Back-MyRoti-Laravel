<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapak extends Model
{
    use HasFactory;

    protected $fillable = ['nama_lapak', 'alamat', 'contact_lapak', 'image', 'id_area', 'id_kurir'];

    protected $table = 'lapak';


    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }

    public function kurir()
    {
        return $this->belongsTo(Kurir::class, 'id_kurir');
    }
}