<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    protected $table = "penghuni";
    protected $fillable = [
        'nama',
        'foto_ktp',
        'status_penghuni',
        'nomor_telepon',
        'status_perkawinan',
    ];
    
}
