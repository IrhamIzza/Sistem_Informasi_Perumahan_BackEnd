<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaranSeeder extends Seeder
{
    public function run()
    {
        $iuranSatpam = DB::table('iuran')->where('nama', 'Satpam')->orderBy('id', 'desc')->first();
        $iuranKebersihan = DB::table('iuran')->where('nama', 'Kebersihan')->orderBy('id', 'desc')->first();

        $bulan = now()->month;
        $tahun = now()->year;
        $tanggalBayar = now();

        for ($rumah = 1; $rumah <= 20; $rumah++) {
            // Insert Satpam
            DB::table('pembayaran')->insert([
                'id_rumah' => $rumah,
                'id_iuran' => $iuranSatpam->id,
                'periode_bulan' => $bulan,
                'periode_tahun' => $tahun,
                'tanggal_bayar' => $tanggalBayar,
                'status_lunas' => 'belum',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert Kebersihan
            DB::table('pembayaran')->insert([
                'id_rumah' => $rumah,
                'id_iuran' => $iuranKebersihan->id,
                'periode_bulan' => $bulan,
                'periode_tahun' => $tahun,
                'tanggal_bayar' => $tanggalBayar,
                'status_lunas' => 'belum',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}