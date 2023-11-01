<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['nama_area'];

    protected $table = 'area';

    public function lapak()
    {
        return $this->hasMany(Lapak::class);
    }
}