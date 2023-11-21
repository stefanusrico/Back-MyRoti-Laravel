<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'id_area'];


    protected $table = 'kurir';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }


    public function alokasi()
    {
        return $this->hasMany(Alokasi::class);
    }
}