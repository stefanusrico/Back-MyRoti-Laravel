<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Kurir extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kurir','area_id'];

    protected $primaryKey = "id";

    
    protected $table = 'kurir';

    public static function forgetCache()
    {
        Cache::forget('id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }


    public function alokasi()
    {
        return $this->hasMany(Alokasi::class);
    }
}