<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    protected $table = "iuran";
    protected $fillable = [
        'nama',
        'nominal',
        'berlaku_mulai',
    ];
}
