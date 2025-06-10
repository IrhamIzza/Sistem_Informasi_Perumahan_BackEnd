<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenghuniRumah extends Model
{
    public $timestamps = false;
    protected $table = "penghuni_rumah";
    protected $fillable = [
        'id_penghuni',
        'id_rumah',
        'tanggal_mulai',
        'tanggal_selesai',
    ];
    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'id_penghuni');
    }

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'id_rumah');
    }
}
