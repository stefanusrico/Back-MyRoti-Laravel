<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koordinator extends Model
{
    use HasFactory;

    protected $fillable = ["nama_koordinator", "user_id"];
    protected $table = 'koordinator';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}