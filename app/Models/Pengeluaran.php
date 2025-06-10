<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $table = "pengeluaran";
    protected $fillable = [
        'nama',
        'tanggal',
        'nominal',
        'keterangan'
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
