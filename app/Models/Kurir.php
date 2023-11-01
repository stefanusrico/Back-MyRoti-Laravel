<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kurir','area_id'];

    
    protected $table = 'kurir';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function area()
    {
        return $this->hasMany(Area::class);
    }

    public function alokasi()
    {
        return $this->hasMany(Alokasi::class);
    }
}