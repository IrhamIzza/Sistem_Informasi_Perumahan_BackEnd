<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    //
    protected $table = "pembayaran";
    protected $fillable = [
        'id_penghuni',
        'id_rumah',
        'id_iuran',
        'periode_bulan',
        'periode_tahun',
        'tanggal_bayar',
    ];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'id_rumah');
    }

    public function iuran()
    {
        return $this->belongsTo(Iuran::class, 'id_iuran');
    }
}
