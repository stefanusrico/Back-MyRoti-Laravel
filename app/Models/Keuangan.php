<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;


    protected $fillable = ["nama_keuangan", "user_id"];
    protected $table = 'keuangan';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}