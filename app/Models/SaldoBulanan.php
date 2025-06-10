<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoBulanan extends Model
{
    protected $table = "saldo_bulanan";
    protected $fillable = [
        'bulan',
        'tahun',
        'total_pemasukan',
        'total_pengeluaran',
        'saldo_akhir',
    ];

}
