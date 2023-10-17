<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapak extends Model
{
    protected $table = 'lapak'; // Nama tabel dalam database

    protected $fillable = ['nama_warung', 'area','alamat_warung', 'contact_warung', 'image']; // Kolom-kolom yang bisa diisi

    public $timestamps = true;
}