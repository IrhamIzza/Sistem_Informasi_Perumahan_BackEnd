<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    protected $table = "rumah";
    protected $fillable = [
        'nomer_rumah',
        'status_huni',
    ];

    public function penghuniAktif()
    {
        return $this->hasOne(PenghuniRumah::class)->whereNull('tanggal_selesai');
    }

    public function historiPenghuni()
    {
        return $this->hasMany(PenghuniRumah::class);
    }
}
